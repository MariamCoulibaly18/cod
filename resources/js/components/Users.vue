<template>
<div class="container-fluid">
 <div class="col-md-12">
    <div class="card">
      <div class="card-header" style="background-color: #C5D8D1;">
        <h3 class="card-title text-white">Users</h3>
        <div class="card-tools">
          <button class="btn btn-block btn-light" @click="addModal" style="color: #01356F;" >
            Nouveau <i class="fa-solid fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body table-responsive">
        <div class="row mt-3 ">
          <div class="col">
            <input type="text" class="form-control" placeholder="Rechercher par nom" v-model="search.name">
          </div>
          <div class="col">
            <input type="text" class="form-control" placeholder="Rechercher par Email" v-model="search.email">
          </div>
          <div class="col">
            <select class="form-select" v-model="search.type">
              <option value="">Selectionner le Type</option>
              <option value="admin">Super Administrateur</option>
              <option value="admin">Administrateur</option>
              <option value="livreur">Livreur</option>
            </select>
          </div>
        </div>
        <table class="table table-hover text-nowrap">
          <div class="spinner-container" v-if="isLoading" style="top: 50%;transform: translate(-50%, -50%);">
            <loader></loader>
          </div>
          <thead>
              <th>ID</th>
              <th>Nom</th>
              <th>Email</th>
              <th>Type</th>
              <th>
                Enregistré à
                <a @click="sortByCreatedAt" style="cursor:pointer">
                  <i  class="fas fa-sort-up blue" v-if="this.search.date_sort_order !== 'asc'"></i>
                  <i class="fas fa-sort-down blue" v-if="this.search.date_sort_order !== 'desc'"></i>
                </a>
              </th>
              <th>Actions</th>
          </thead>
          <tbody>
              <tr v-if="!isLoading" v-for="user in paginatedUsers" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name |  upText  }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.type |  upText }}</td>
                <td>{{ user.created_at | myDate }}</td>
                <td>
                  <button class="btn btn-info btn" @click="editModal(user)">
                    <i class="fas fa-edit fa-fw"></i>
                  </button>
                  <button class="btn btn-danger btn" v-if="user.id != currentUser.id"  @click="deleteUser(user.id)">
                      <i class="fas fa-trash fa-fw"></i>
                  </button>
                </td>
              </tr>
          </tbody>
        </table>      
      </div>
      <div v-if="!isLoading" class="card-footer d-flex justify-content-center">
          <nav >
           <ul class="pagination">
             <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                 <a class="page-link" href="#" aria-label="Previous" @click.prevent="changePage(pagination.current_page - 1)">
                   Précédent
                 </a>
               </li>
             <li class="page-item" v-for="page in pagination.total_pages" :key="page" :class="{ active: page === pagination.current_page }">
                  <a class="page-link"  @click.prevent="changePage(page)">{{ page }}</a>
                </li>
              <li class="page-item" :class="{ disabled: pagination.current_page === pagination.total_pages }">
                   <a class="page-link" href="#" aria-label="Next" @click.prevent="changePage(pagination.current_page + 1)">
                     Suivant
                   </a>
                 </li> 
             </ul>
          </nav>
       </div> 

  </div>

  </div>
  <!-- Modal -->
  <div class="modal fade" id="AddnewModal" tabindex="-1" aria-labelledby="AddnewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddnewModalLabel" v-if="!editMode">Ajouter un nouvel utilisateur</h5>
        <h5 class="modal-title" id="AddnewModalLabel" v-if="editMode">Modifier utilisateur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form @submit.prevent="editMode ? updateUser() : createUser()">
      <div class="modal-body">
        <div class="form-group">
          <label>Nom</label>
          <input v-model="form.name" type="text" name="name"
          placeholder="Nom"
            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
          <has-error :form="form" field="name"></has-error>
        </div>
        <div class="form-group">
          <label>Type d'utilisateur</label>
          <select v-model="form.type" type="text" id="type" name="type"

            class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
            <option value="">Selectionner le role de l'utilisateur</option>
            <option value="super_admin">Super Administrateur</option>
            <option value="admin">Administrateur</option>
            <option value="livreur">Livreur</option>
            </select>
          <has-error :form="form" field="type"></has-error>
        </div>
        
        <div class="form-group">
          <label>Email</label>
          <input v-model="form.email" type="email" name="email"
            placeholder="Adresse Email"
            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
          <has-error :form="form" field="email"></has-error>
        </div>
        <div class="form-group">
          <label>Mot de passe</label>
          <input v-model="form.password" type="password" id="password" name="password"
            placeholder="mot de passe"
            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
          <has-error :form="form" field="password"></has-error>
        </div>
        <!-- password confirmation -->
        <div class="form-group">
          <label>Confirmer votre mot de passe</label>
          <input v-model="form.password_confirmation" type="password" id="password_confirmation"
            name="password_confirmation" placeholder="confirmer mot de passe"
            class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirmation') }">
          <has-error :form="form" field="password_confirmation"></has-error>
        </div>

      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-danger rounded-pill px-4" data-bs-dismiss="modal"> Annuler </button>
        <button type="submit" class="btn btn-primary rounded-pill px-4" v-if="!editMode">Ajouter</button>
        <button type="submit" class="btn btn-primary rounded-pill px-4" v-if="editMode"> Modifier</button>
      </div>
    </form>
    </div>
  </div>
  </div>


  </div>
</template>

<script>
import { assertExpressionStatement } from '@babel/types';

export default {
    data: () => ({
    
      users:{}  , 
      currentUser: '',  
      form: new Form({
        id:'',
        name: '',
        email: '',
        password:'',
        password_confirmation:'',
        type:''
    }),
    search : {
      name:'',
      email:'',
      type:'',
      date_sort_order:'desc'
    },
    editMode: false,
    isLoading:true,
    //pagination
      pagination:{
        current_page:1,
        per_page:5,
        total_pages:0,
       },
      
}),
created(){
  if(!this.$gate.isSuperAdmin())
    this.$router.push('/404');

  // currentUser
  this.currentUser = window.user;
  console.log(this.currentUser);
  //load users
  this.loadUsers();
},
computed : {
    filteredUsers(){
      let filtered = Object.values(this.users);
      if (this.search.name !== '') {
        filtered = filtered.filter(user =>
          user.name.toLowerCase().includes(this.search.name.toLowerCase())
        );
      }
      if (this.search.email !== '') {
        filtered = filtered.filter(user =>
          user.email.toLowerCase().includes(this.search.email.toLowerCase())
        );
      }
      if (this.search.type !== '' && this.search.type !== 'all') {
        filtered = filtered.filter(user =>
          user.type.toLowerCase() === this.search.type.toLowerCase()
          );
      }

      //date sort
      filtered.sort((a, b) => {
        if (this.search.date_sort_order === 'asc') {
          return new Date(a.created_at) - new Date(b.created_at);
        } else {
          return new Date(b.created_at) - new Date(a.created_at);
        }
      });

      return filtered;
    },
     //pagination
     paginatedUsers(){
      this.pagination.total_pages = Math.ceil(this.filteredUsers.length / this.pagination.per_page);
      return this.filteredUsers.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
    },
},
methods:{
   //pagination
   changePage(page){
        this.pagination.current_page = page;
      },
  //
  sortByCreatedAt() {
    this.search.date_sort_order = this.search.date_sort_order === 'asc' ? 'desc' : 'asc';
  },
  
  loadUsers(){
    axios.get('/api/user')
    .then((response) => {
      console.log(response.data);
      this.users = response.data.data;
      this.isLoading = false;
    })
    .catch(({response}) => console.log(response.data));
  },

  createUser(){
    this.form.post('/api/user')
    .then((response) => {
      $('#AddnewModal').modal('hide');
      Swal.fire(
        'Bon travail!',
        "L'utilisateur a été ajouté avec succès!",
        'success'
      );
      this.loadUsers();
    })
    .catch(({response}) => {
      console.log(response.data);
    });
  },
  updateUser(){
    this.form.put(`/api/user/${this.form.id}`)
    .then(() => {
      $('#AddnewModal').modal('hide');
      Swal.fire(
        'Bon travail!',
        "L'utilisateur a été modifié avec succès!",
        'success'
      );
      this.loadUsers();
    })
    .catch(({response}) => {
      this.$toast.error(response.data.message);
    });
  },
  deleteUser(id){
    //Swal confirm
    Swal.fire({
      title: 'Êtes-vous sûr?',
      text: "Vous ne pourrez pas revenir en arrière!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3b3f5c',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Oui, supprimez-le!',
      cancelButtonText: 'Annuler',
    }).then((result) => {
      if (result.isConfirmed) {
        axios.delete(`/api/user/${id}`)
        .then(() => {
          this.loadUsers();
          Swal.fire(
            'Supprimé!',
            'Votre fichier a été supprimé',
            'success'
          )
        })
        .catch(({response}) => {
          console.log(response.data);
        });
      }
    })
    
    
  },
  editModal(user){
    this.editMode = true;
    this.form.reset();
    this.form.fill(user);
    $('#AddnewModal').modal('show');
  },
  addModal(){
    this.editMode = false;
    this.form.reset();
    $('#AddnewModal').modal('show');
  },

}

    
}
</script>
<style>
/* Modifier la taille de police pour les en-têtes */
.card-header h3.card-title {
  font-size: 22px; 
  color: #01356F;
   
}

/* Modifier la taille de police pour les boutons */
.btn {
  font-size: 14px; 
}

/* Modifier la taille de police pour les cellules de tableau */
.table td, .table th {
  font-size: 14px;
  color: #01356F;

}

/* Modifier la taille de police pour les champs de formulaire */
.form-control {
  font-size: 16px; 
}

/* Modifier la taille de police pour les liens de pagination */
.pagination .page-link {
  font-size: 12px; 
  color: #552561;

}

/* Modifier la taille de police pour les titres de modal */
.modal-title {
  font-size: 20px; 
}
.row.m-3 .col input.form-control,
.row.m-3 .col select.form-control {
  font-size: 13px; 
}

.spinner-container {
    position: fixed;
    top: 43%; /* Ajustez cette valeur pour centrer verticalement */
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999; /* Assurez-vous que le spinner est au-dessus de tout le reste */
    background-color: rgba(255, 255, 255, 0.7); /* Un arrière-plan semi-transparent pour le contraste */
}
.row.mt-3 .col input.form-control,
.row.mt-3 .col select.form-control {
  font-size: 13px; 
}
</style>