<template>
<div class="container-fluid">
 <div class="col-md-12">
    <div class="card">
      <div class="card-header" style="background-color: #2f4fb1; display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
      <h3 class="card-title text-white">Boutiques Types</h3>
      <div class="card-tools">
        <button class="btn btn-light" @click="addModal"  style="color: #01356F; "  >Nouveau <i class="ti ti-plus"></i></button>
      </div>
    </div>
        
    <div class="card-body table-responsive p-0">
      <div class="row m-3 ">
        <div class="col-4">
          <input type="text" class="form-control" placeholder="Rechercher par nom" v-model="search.name">
        </div>
      </div>
      <table class="table table-hover text-nowrap">
        <thead>
            <th>ID</th>
            <th>Icone</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <tr v-for="store_type in paginatedStoreTypes" :key="store_type.id">
                <td>{{store_type.id}}</td>
                <td><img :src="store_type.icon | store_type_icon_filter" alt="" width="50" height="50"></td>
                <td>{{store_type.name}}</td>
                <td>{{store_type.description}}</td>
                <td>
                  <button class="btn btn-info" @click="editModal(store_type)"><i class="ti ti-edit"></i></button>
                  <button class="btn btn-danger" @click="deleteStoreType(store_type.id)"><i class="ti ti-trash-x"></i></button>
                </td>
            </tr>
        </tbody>
      </table>
    </div>
    <div class="card-footer d-flex justify-content-center">
       <nav >
         <ul class="pagination">
           <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
               <a class="page-link" href="#" aria-label="Previous" @click.prevent="changePage(pagination.current_page - 1)">
                  Précédent
                </a>
            </li>
            <li class="page-item" v-for="page in pagination.total_pages" :key="page" :class="{ active: page === pagination.current_page }">
                <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
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
        <h5 class="modal-title" id="AddnewModalLabel" v-if="!editMode">Ajouter un nouveau type</h5>
        <h5 class="modal-title" id="AddnewModalLabel" v-if="editMode">Modifier un type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form @submit.prevent="editMode ? updateStoreType() : createStoreType()">
      <div class="modal-body">
        <!-- Icon is image field-->
        <div class="form-group">
          <label>Icone</label>
          <input type="file" name="icon"
            placeholder="Icone" ref="icon"
            class="form-control" :class="{ 'is-invalid': form.errors.has('icon') }">
          <has-error :form="form" field="icon"></has-error>
        </div>
        <!-- Name-->
        <div class="form-group">
          <label>Nom</label>
          <input v-model="form.name" type="text" name="name"
            placeholder="Nom"
            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
          <has-error :form="form" field="name"></has-error>
        </div>

        <!-- Description is a text field-->
        <div class="form-group">
          <label>Description</label>
          <textarea v-model="form.description" name="description"
            placeholder="Description"
            class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
          </textarea>
          <has-error :form="form" field="description"></has-error>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> Fermer</button>
        <button type="submit" class="btn btn-primary" v-if="!editMode"> Ajouter</button>
        <button type="submit" class="btn btn-primary" v-if="editMode"> <i class="fa fa-edit white"></i></button>
      </div>
    </form>
    </div>
  </div>
  </div>


  </div>
</template>

<script>
  export default {
      data: () => ({
     
       store_types: [],
       form: new Form({
         id:'',
         name:'',
         icon:'',
         description:'',
      }),
      search : {
        name:'',
      },
      //pagination
      pagination:{
        current_page:1,
        per_page:5,
        total_pages:0,
        },
      editMode: false,
       
}),
methods:{
  //pagination
 changePage(page){
         this.pagination.current_page = page;
        },
  loadStoreTypes(){
    axios.get('/api/boutique_type')
    .then(({data}) => {
      this.store_types = data.data;
      console.log(this.store_types);
    })
    .catch(({response}) => {
      console.log(response.data);
    });
  },

  createStoreType(){
    //set the image to the form
    this.form.icon = this.$refs.icon.files[0];

    this.form.post('/api/boutique_type')
    .then((response) => {
      $('#AddnewModal').modal('hide');
      Swal.fire(
        'Bon travail!',
        'Type de boutique ajouté avec succès !',
        'success'
      );
      console.log(response.data);
      this.loadStoreTypes();
    })
    .catch(({response}) => {
      console.log(response.data);
    });
  },
  updateStoreType(){
    this.form.put(`/api/boutique_type/${this.form.id}`)
    .then((response) => {
      $('#AddnewModal').modal('hide');
      Swal.fire(
        'Bon travail!!',
        'Type a été mise à jour avec succès !',
        'success'
      );
      console.log(response.data);
      this.loadStoreTypes();
    })
    .catch(({response}) => {
      this.$toast.error(response.data.message);
    });
  },
  deleteStoreType(id){
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
        axios.delete(`/api/boutique_type/${id}`)
        .then(() => {
          this.loadStoreTypes();
          Swal.fire(
            'Supprimé!',
            'Le type a été supprimé',
            'success'
          )
        })
        .catch(({response}) => {
          console.log(response.data);
        });
      }
    })
    
    
  },
  editModal(store_type){
    this.editMode = true;
    this.form.fill(store_type);
    this.form.icon = store_type.icon;
    $('#AddnewModal').modal('show');
  },
  addModal(){
    this.editMode = false;
    $('#AddnewModal').modal('show');
  },
  closeModal(){
    this.editMode = false;
    this.form.reset();
    this.form.clear();
    $('#AddnewModal').modal('hide');
  },
  loadStoreTypesTypes(){
    axios.get('api/boutique_type')
    .then(({data}) => {
      this.store_types = data.data;
    })
    .catch(({response}) => {
      console.log(response.data);
    });
  },
  loadStoreTypesUsers(){
    axios.get('api/user')
    .then(({data}) => {
      this.store_users = data.data;
      console.log(data.data);
    })
    .catch(({response}) => {
      console.log(response.data);
    });
  },

},
computed : {
  paginatedStoreTypes(){
        this.pagination.total_pages = Math.ceil(this.filteredStoresTypes.length / this.pagination.per_page);
        return this.filteredStoresTypes.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
       },
    filteredStoresTypes(){
        let filtered = Object.values(this.store_types);
        filtered = filtered.filter(store => {
            return store.name.toLowerCase().includes(this.search.name.toLowerCase());
        });
       
        return filtered;
    },
},
mounted(){
  if(!this.$gate.isSuperAdmin())
    this.$router.push('/404');

  this.loadStoreTypes();
}
    
}
</script>
<style>
/* Modifier la taille de police pour les en-têtes */
.card-header h3.card-title {
  font-size: 22px; 
}

/* Modifier la taille de police pour les boutons */
.btn {
  font-size: 14px; 
}

/* Modifier la taille de police pour les cellules de tableau */
.table td, .table th {
  font-size: 14px;
}

/* Modifier la taille de police pour les champs de formulaire */
.form-control {
  font-size: 16px; 
}

/* Modifier la taille de police pour les liens de pagination */
.pagination .page-link {
  font-size: 12px; 
}

/* Modifier la taille de police pour les titres de modal */
.modal-title {
  font-size: 20px; 
}
.row.m-3 .col-4 input.form-control{
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
</style>