<template>
<div class="container-fluid">
 <div class="col-md-12">
    <div class="card">
      <div class="card-header" style="background-color: #2f4fb1; display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
      <h3 class="card-title text-white">Boutiques</h3>
      <div class="card-tools">
        <button v-if="$gate.isSuperAdmin()" class="btn btn-light" @click="addModal" style="color: #01356F;" >Nouveau <i class="ti ti-plus"></i></button>
      </div>
    </div>
        
    <div class="card-body table-responsive p-0">
      <div class="row m-3 ">
        <div class="col" >
          <input type="text" class="form-control" placeholder="Rechercher par nom" v-model="search.name"  >
        </div>
        <div class="col">
          <input type="url" class="form-control" placeholder="Rechercher par URL de la boutique" v-model="search.store_url">
        </div>
        <div v-if="$gate.isSuperAdmin()" class="col">
          <input type="text" class="form-control" placeholder="Rechercher par responsable" v-model="search.user">
        </div>
        <div class="col">
            <select class="form-control" v-model="search.type">
                <option value="">Selectionner le type</option>
                <option v-for="store_type in store_types" :key="store_type.id" :value="store_type.id">{{store_type.name}}</option>
            </select>
        </div>
      </div>
      <table class="table table-hover text-nowrap">
        <div class="spinner-container" v-if="isLoading" style="top: 50%;transform: translate(-50%, -50%);">
          <loader></loader>
        </div>
        <thead>
            <th>ID</th>
            <th>Nom boutique</th>
            <th>Type</th>
            <th v-if="$gate.isSuperAdmin()">Responsable</th>
            <th>Url de la boutique</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <tr v-if="!isLoading" v-for="store in paginatedStores" :key="store.id">
                <td>{{store.id}}</td>
                <td>{{store.name}}</td>
                <td><img :src="store.type.icon | store_type_icon_filter" alt="icon" width="30px" height="30px"></td>
                <td v-if="$gate.isSuperAdmin()">{{ store.user.name }}</td>
                <td>{{store.store_url}}</td>
                <td>
                    <span v-if="!$store.getters.currentBoutique || $store.getters.currentBoutique.id != store.id">
                      <button v-if="connect_id != store.id"  class="btn btn-success" @click="enterStore(store)"> <i class="ti ti-indent-increase"></i></button>
                      <button v-if="connect_id === store.id && isConnecting" class="btn btn-success">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Connecting...
                      </button>
                      <button v-if="$gate.isResponsible(store) || $gate.isSuperAdmin()" class="btn btn-info" @click="editModal(store)"><i class="ti ti-edit"></i></button>
                      <button v-if="$gate.isSuperAdmin()" class="btn btn-danger" @click="deleteStore(store.id)"> <i class="ti ti-trash-x"></i></button>
                    </span>
                    <button v-else class="btn btn-danger" @click="quitStore()"> <i class="ti ti-indent-decrease"></i></button>
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
              <a class="page-link" href="#" aria-label="Next" @click.prevent="changePage(pagination.current_page + 1)" >
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
        <h5 class="modal-title" id="AddnewModalLabel" v-if="!editMode">Ajouter une nouvelle boutique</h5>
        <h5 class="modal-title" id="AddnewModalLabel" v-if="editMode">Modifier une boutique</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeModal"></button>
      </div>
      <form @submit.prevent="editMode ? updateStore() : createStore()" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="form-group">
          <label>Logo de la boutique</label>
          <input type="file" ref="logo" name="logo" accept="image/*"  @change="updateLogo">
        </div>
        <div class="form-group">
          <label>Nom</label>
          <input v-model="form.name" type="text" name="name"
          placeholder="Nom"
            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
          <has-error :form="form" field="name"></has-error>
        </div>

        <div class="form-group">
          <label>Type de boutique</label>
          <select v-model="form.type.id" type="text" id="type" name="type"
            class="form-control" :class="{ 'is-invalid': form.errors.has('type.id') }">
            <option value="">Selectionner un type</option>
            <option v-for="store_type in store_types" :key="store_type.id" :value="store_type.id">{{store_type.name}}</option>
          </select>
          <has-error :form="form" field="type.id"></has-error>
        </div>

        <div v-show="$gate.isSuperAdmin()" class="form-group">
          <label>Responsable</label>
          <select v-model="form.user.id" type="text" id="user" name="user"
            class="form-control" :class="{ 'is-invalid': form.errors.has('user.id') }">
            <option value="">Selectionner le responsable</option>
            <option v-for="user in store_users" :key="user.id" :value="user.id">{{user.name}}</option>
          </select>
          <has-error :form="form" field="user.id"></has-error>
        </div>

        <div class="form-group">
          <label>Url de la boutique</label>
          <input v-model="form.store_url" type="url" name="store_url"
            placeholder="Store Url"
            class="form-control" :class="{ 'is-invalid': form.errors.has('store_url') }">
          <has-error :form="form" field="store_url"></has-error>
        </div>

        <div class="form-group">
          <label>Clé du consommateur</label>
          <input v-model="form.consumer_key" type="text" name="consumer_key"
            placeholder="Consumer Key"
            class="form-control" :class="{ 'is-invalid': form.errors.has('consumer_key') }">
          <has-error :form="form" field="consumer_key"></has-error>
        </div>

        <div class="form-group">
          <label>Secret du consommateur</label>
          <input v-model="form.consumer_secret" type="text" name="consumer_secret"
            placeholder="Consumer Secret"
            class="form-control" :class="{ 'is-invalid': form.errors.has('consumer_secret') }">
          <has-error :form="form" field="consumer_secret"></has-error>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="closeModal">Fermer</button>
        <button type="submit" class="btn btn-primary" v-if="!editMode">Ajouter </button>
        <button type="submit" class="btn btn-primary" v-if="editMode">Mondifier</button>
      </div>
    </form>
    </div>
  </div>
  </div>
  
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

  export default {
      data: () => ({
     
       stores:[], 
       store_types:[],
       store_users:[], 
       form: new Form({
         id:'',
         name:'',
         store_url:'',
         logo:'',
         consumer_key:'',
         consumer_secret:'',
         type:{
              id:'',
              name:'',
              icon:'',
              descipriont:'',
         },
         user:{
              id:'',
              name:'',
         },

      }),
      search : {
        name:'',
        store_url:'',
        type:'',
        user:'',
      },
      //pagination
      pagination:{
        current_page:1,
        per_page:5,
        total_pages:0,
        },
      isLoading:true,
      editMode: false,
      isConnecting:false,
      connect_id:'',
      visites:'',
      ventes:'',
       
}),
computed : {
  paginatedStores(){
        this.pagination.total_pages = Math.ceil(this.filteredStores.length / this.pagination.per_page);
        return this.filteredStores.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
       },
    filteredStores(){
        let filtered = Object.values(this.stores);
        if (this.search.name !== '') {
            filtered = filtered.filter(store =>
            store.name.toLowerCase().startsWith(this.search.name.toLowerCase())
        );
        }

        if (this.search.store_url !== '') {
            filtered = filtered.filter(store =>
            store.store_url.toLowerCase().includes(this.search.store_url.toLowerCase())
            );
        }
        if (this.search.type !== '') {
            filtered = filtered.filter(store =>
            store.type.id == this.search.type
            );
        }
        if (this.search.user !== '') {
            filtered = filtered.filter(store =>
            store.user.name.toLowerCase().startsWith(this.search.user.toLowerCase())
            );
        }

      return filtered;
    },
},
created(){
    console.log('Composant monté.')
    this.loadStores();
},
mounted(){
    this.loadStoresTypes();
    this.loadStoresUsers();
    console.log('Composant monté.')
},

methods:{
 //pagination
 changePage(page){
         this.pagination.current_page = page;
        },
  //
  loadStores(){
    axios.get('/api/boutique')
    .then(({data}) => {
      this.stores = data.data;
      console.log(this.stores);
      this.isLoading = false;
    })
    .catch(({response}) => {
      console.log(response.data);
    });
  },
  loadStoresTypes(){
    axios.get('api/boutique_type')
    .then(({data}) => {
      this.store_types = data.data;
    })
    .catch(({response}) => {
      console.log(response.data);
    });
  },
  loadStoresUsers(){
    if(!this.$gate.isSuperAdmin())
        return ;

    axios.get('api/user')
    .then(({data}) => {
      this.store_users = data.data;
      // filter the users to get only the users with the role admin
      this.store_users = this.store_users.filter(user => user.type === 'admin' || user.type === 'super_admin');
      console.log(data.data);
    })
    .catch(({response}) => {
      console.log(response.data);
    });
  },
  createStore(){
    if(!this.$gate.isSuperAdmin())
        return ;
    this.form.logo = this.$refs.logo.files[0];
    this.form.post('/api/boutique')
    .then((response) => {
      $('#AddnewModal').modal('hide');
      Swal.fire(
        'Bon travail!',
        'Boutique ajoutée avec succès !',
        'success'
      );
      console.log(response.data);
      this.loadStores();
    })
    .catch(({response}) => {
      console.log(response.data);
    });
  },
  updateStore(){

    const store = this.stores.find(store => store.id == this.form.id);
    if(!this.$gate.isSuperAdmin() && !this.$gate.isResponsible(store))
        return ;
        console.log(this.form);
    this.form.put(`/api/boutique/${this.form.id}`)
    .then(() => {
      $('#AddnewModal').modal('hide');
      Swal.fire(
        'Bon travail!!',
        'La boutique a été mise à jour avec succès !',
        'success'
      );
      this.loadStores();
    })
    .catch(({response}) => {
      this.$toast.error(response.data.message);
    });
  },
  
  deleteStore(id){
    if(!this.$gate.isSuperAdmin())
        return ;
    //Swal confirm
    Swal.fire({
      title: 'Êtes-vous sûr?',
      text: "Vous ne pourrez pas revenir en arrière!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3b3f5c',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Oui, supprimez-la!',
      cancelButtonText: 'Annuler',
    }).then((result) => {
      if (result.isConfirmed) {
        axios.delete(`/api/boutique/${id}`)
        .then((response) => {
          this.loadStores();
          Swal.fire(
            'Supprimé!',
            'La boutique a été supprimé',
            'success'
          )
          console.log(response.data);
        })
        .catch(({response}) => {
          console.log(response.data);
        });
      }
    })
    
    
  },
  updateLogo(event) {
    const file = event.target.files[0];
    this.form.logo = file;
  },
  editModal(store){
    this.editMode = true;
    // const storeCopy = {...store};
    this.form.fill(store);
    console.log(this.form);
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
  enterStore(store){
    //console.log(this.$gate.isResponsible(store));
    if(!this.$gate.isResponsible(store) &&  !this.$gate.isSuperAdmin()){
      //swal to tell him that he is not allowed to enter this store
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "Vous n'êtes pas autorisé à entrer dans ce magasin!",
      });
      return ;
    }
    //fire.$emit('switchBoutique', store);
    //swal pour lui dire qu'il est entré dans le store
    //il faut ajouter par la suite un request au api pour verifier si le store est bien connecté(woocommerce, prestashop, shopify...)
    if(store.type.name != 'Local'){
      this.connect_id = store.id;
      this.isConnecting = true;
      axios.get(`/api/boutique/${store.id}/connect`)
        .then((response) => {
          console.log(response);
          // this.visites=data.visites;
          // this.ventes= data.ventes;
          // console.log(this.visites);
          // console.log(this.ventes);
          this.connect_id = '';
          this.isConnecting = false;
          this.$store.commit('switchBoutique', store);
        })
        .catch(({response}) => {
          this.connect_id = '';
          this.isConnecting = false;
          Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: response.data.error,
            });
        });
       return ; 
    }

    this.$store.commit('switchBoutique', store);
    //this.$router.push({name:'orders'});
  },
  quitStore(){
    this.$store.commit('switchBoutique', null);
    this.$router.push({name:'boutiques'});
  },

},

    
}
</script>

<style scoped>
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
  color: #01356F ;
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
</style>
