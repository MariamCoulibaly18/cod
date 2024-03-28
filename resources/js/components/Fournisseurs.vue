<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-white">Fournisseurs</h3>
                        <div class="card-tools">
                            <button class="btn btn-light" @click="showBrands()" style="color: #01356F; ">
                                Marques
                                <i class="fa-sharp fa-solid fa-list"></i>
                            </button>
                            <button class="btn btn-light" @click="newModal"  style="color: #01356F;" >
                                Nouveau <i class="fa-solid fa-plus"></i>
                            </button>
                         
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="row mt-3">
                        <div class="col-8 mt-2 justify-content-center col-md-3">
                            <input type="text" class="form-control" style="font-size:13px" placeholder="Nom" v-model="search.name" />
                        </div>
                        <!-- Adresse-->
                        <div class="col-8 mt-2 justify-content-center col-md-3">
                            <input type="text" class="form-control" style="font-size:13px" placeholder="Adresse" v-model="search.adresse" />
                        </div>
                        <!-- Type fournisseur-->
                        <div class="col-8 mt-2 col-md-3">
                            <select class="form-select" style="font-size:13px" v-model="search.type">
                            <option value="">Selectionner le type de fournisseur</option>
                            <option v-for="typeFournisseur in types" :key="typeFournisseur.id" :value="typeFournisseur.id">{{ typeFournisseur.type}}</option>
                            </select>
                        </div>
                        
                        </div>
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Telephone</th>
                                <th>Adresse</th>
                                <th>Type fournisseur</th>
                                <th>Marques</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                <tr v-for="fournisseur in paginatedFournisseurs" :key="fournisseur.id">
                                    <td >{{ fournisseur.id }}</td>
                                    <td>{{ fournisseur.name }}</td>
                                    <td>{{ fournisseur.telephone }}</td>
                                    <td>{{ fournisseur.adresse }}</td>
                                    <td >{{ fournisseur.type.type }}</td>
                                    <td>
                                        <a class="btn" @click="showMarques(fournisseur)" style="background-color: rgb(179, 178, 178);">
                                            <i class="fa fa-eye white" ></i>
                                        </a>
                                        <a class="btn btn-success ms-2" @click="addMarques(fournisseur)">
                                            <i class="fa fa-plus-circle white" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <button @click="editModal(fournisseur)" class="btn btn-info">
                                                <i class="fas fa-edit fa-fw"></i>
                                        </button>
                                        <button class="btn btn-danger" @click="deleteFournisseur(fournisseur.id)">
                                            <i class="fa fa-trash white"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> 
                    <div  class="card-footer d-flex justify-content-center">
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
        </div>
        <!-- Add and Edit Modal -->
        <div class="modal fade" id="add_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editMode">Ajouter Fournisseur</h5>
                    <h5 class="modal-title" v-show="editMode">Modifier Fournisseur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" @click="closeAddModal()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode ? updateFournisseur() : createFournisseur()">
                    <div class="modal-body">
                        <div class="container">   
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <label for="name">Nom</label>
                                    <input type="text" class="form-control" id="name" placeholder="Entrer le nom" v-model="form.name">       
                                </div>
                                <div class="col-md-12 mt-2">
                                    <label for="telephone">Telephone</label>
                                    <input type="text" class="form-control" id="telephone" placeholder="Entrer le numero de téléphone" v-model="form.telephone">       
                                </div>
                                <div class="col-md-12 mt-2">
                                    <label for="adresse">Adresse</label>
                                    <input type="text" class="form-control" id="adresse" placeholder="Entrer l'adresse" v-model="form.adresse">       
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="form-group">
                                        <label>Types fournisseurs</label>
                                        <select v-model="form.type.id" type="text" id="type" name="type"
                                            class="form-select" :class="{ 'is-invalid': form.errors.has('type.id') }">
                                            <option value="">Seletionner le type </option>
                                            <option v-for="typeFournisseur in types" :key="typeFournisseur.id" :value="typeFournisseur.id">{{typeFournisseur.type}}</option>
                                        </select>
                                        <has-error :form="form" field="type.id"></has-error>
                                    </div>
                                </div>
                            </div>                             
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger rounded-pill px-4" data-dismiss="modal" @click="closeAddModal()">Annuler</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4" v-show="!editMode">Ajouter</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4" v-show="editMode">Modifier</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

        <!-- Marques modals-->
        <div >
            <div class="modal fade" id="marques_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Marques</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" @click=closeShowMarques()>
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">   
                            <div class="row">
                                <div class="form-group">
                                    <ul>
                                        <li v-for="marque in marques" :key="marque.id">
                                            <span style="font-weight: bold;">Nom:</span>
                                            <span>{{ marque.name }}</span>
                                        </li> 

                                    </ul>
                                </div>
                            </div>                             
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger rounded-pill px-4" data-dismiss="modal" @click="closeShowMarques()">Fermer</button>
                    </div>
                    </div>
                </div>
            </div>
       </div>
         <!-- Modal pour ajouter une marque -->
         <div v-if="marqueAjoute">
                <div class="modal fade" id="addMarqueModal" tabindex="-1" role="dialog" aria-labelledby="addMarqueModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="addMarqueModalLabel">Ajouter une marque</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" @click="closeAddMarque()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        <!-- Formulaire ou menu déroulant pour sélectionner une marque -->
                        <form @submit.prevent="submitMarque">
                            <div class="form-group">
                            <label for="id">Fournisseur :</label>
                            <a>{{ marqueAjoute.name }}</a>
                            </div>
                            <div class="form-group">
                            <label for="marqueSelect">Sélectionner une marque :</label>
                            <select class="form-control" id="marqueSelect" v-model="selectedMarqueId">
                                <option v-for="marque in marques" :key="marque.id" :value="marque.id">{{ marque.name }}</option>
                            </select>
                            </div>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">Ajouter</button>
                        </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger rounded-pill px-4" data-dismiss="modal" @click="closeAddMarque()">Annuler</button>
                        </div>
                    </div>
                    </div>
                </div>
         </div>

            <!-- Brand Modal -->
            <div class="modal fade" id="brandsModal" tabindex="-1" role="dialog" aria-labelledby="brandsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="brandsModalLabel">Gérer les marques</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" @click="closeBrandModal">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add brand form -->
                    <form id="add-brand-form d-flex" @submit.prevent="createBrand()">
                    <div class="form-group">
                        <label for="brand-name">Nom de la marque</label>
                        <input type="text" class="form-control" id="brand-name" name="name" v-model="brand_name" required>
                        <span class="text-danger" v-if="BrandValidationErrors.name">{{ BrandValidationErrors.name }}</span>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Ajouter</button>
                    </form>
                    <!-- brand list -->
                    <ul id="brand-list" class="list-group list-scrollable">
                    <li v-for="brand in marques" :key="brand.id"  class="list-group-item d-flex justify-content-between align-items-center">
                        <div v-show="!brand.editing">{{ brand.name }}</div>
                        <div v-show="brand.editing">
                        <input type="text" class="form-control" v-model="edit_brand.name">
                        <span class="text-danger" v-if="BrandValidationErrors.name">{{ BrandValidationErrors.name }}</span>
                        <input type="text" class="form-control" v-model="edit_brand.description">
                        <span class="text-danger" v-if="BrandValidationErrors.name">{{ BrandValidationErrors.description }}</span>
                        <input type="text" class="form-control" v-model="edit_brand.logo">
                        <span class="text-danger" v-if="BrandValidationErrors.name">{{ BrandValidationErrors.logo }}</span>
                        <button type="button" class="btn btn-sm btn-primary ml-2" @click="saveEditBrand(brand)">Sauvegarder</button>
                        <button type="button" class="btn btn-sm btn-secondary ml-2" @click="cancelEditBrand(brand)">Annuler</button>
                        </div>
                        <div v-show="!brand.editing">
                        <button type="button" class="btn btn-sm btn-primary edit-category" data-category-id="1" @click="editBrand(brand)">Modifier</button>
                        <button type="button" class="btn btn-sm btn-danger delete-category" data-category-id="1" @click="deleteBrand(brand)">Supprimer</button>
                        </div>
                    </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger rounded-pill px-4" data-dismiss="modal" @click="closeBrandModal">Annuler</button>
                </div>
                </div>
            </div>
            </div>

 </div>
</template>

<script>
import Swal from 'sweetalert2';
    export default {
        data() {
            return {
                store_id: null,
                fournisseurs: [],
                editMode: false,
                errors: [],
                marques:[],
                fournisseurMarques:[],
                marqueAjoute: 0,
                selectedMarqueId: null, // ID de la marque sélectionnée
                types:[],
                form: new Form({
                    id: '',
                    name: '',
                    telephone: '',
                    adresse: '',
                    marques:[],
                    type:{
                        id:'',
                        type:'',
                    },
                }),
                search:{
                    name: '',
                    adresse: '',
                    type: '',
                    },
                //pagination
                 pagination:{
                    current_page:1,
                    per_page:5,
                    total_pages:0,
                },
                editMode: false,
                edit_brand:{},
                brand_name: '',
                BrandValidationErrors: {},
            }
        },
        created(){
            // get store from current boutique
            if(this.$store.getters.currentBoutique)
            this.store_id = this.$store.getters.currentBoutique.id;
            this.loadFournisseurs();
            this.loadTypesFournisseurs();
        },
        computed: {
            paginatedFournisseurs(){
                this.pagination.total_pages = Math.ceil(this.filteredFournisseur.length / this.pagination.per_page);
                return this.filteredFournisseur.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
                },
            filteredFournisseur() {
                let filteredFournisseur = Object.values(this.fournisseurs);
                if (this.search.name && this.search.name !== '') {
                    filteredFournisseur = filteredFournisseur.filter((fournisseur) => 
                    fournisseur.name.toLowerCase().includes(this.search.name.toLowerCase())
                );
                }
                if (this.search.adresse && this.search.adresse !== '') {
                filteredFournisseur = filteredFournisseur.filter((fournisseur) => 
                 fournisseur.adresse && fournisseur.adresse.toLowerCase().includes(this.search.adresse.toLowerCase())
                );
            }
                if (this.search.type && this.search.type !== '') {
                     filteredFournisseur = filteredFournisseur.filter(fournisseur => {
                        return fournisseur.type_id == this.search.type;
                });
                }
                return filteredFournisseur;  

            },
        },
        methods:{
            //pagination
            changePage(page){
                this.pagination.current_page = page;
             },
            loadFournisseurs(){
                axios.get(`/api/fournisseur/${this.store_id}`)
                .then(({data}) => {
                    this.fournisseurs = data.data
                    console.log(this.fournisseurs);
                })
                .catch(({response}) => {
                console.log(response.data);
                });
            },
            loadTypesFournisseurs(){
                axios.get('api/type')
                .then(({data}) => {
                this.types = data.data;
                console.log(data.data);
                })
                .catch(({response}) => {
                console.log(response.data);
                });
            },
            loadMarques() {
                axios.get('api/marque')
                .then(({data}) => {
                this.marques = data.data;
                console.log(data.data);
                })
                .catch(({response}) => {
                console.log(response.data);
                });
            },
            showMarques(fournisseur) {
                $('#marques_modal').modal('show');
                // Appeler l'API pour récupérer les marques du fournisseur
                axios.get(`/api/fournisseurs/${fournisseur.id}`)
                .then((response) => {
                // Récupérer la liste des marques depuis la réponse de l'API
                this.marques = response.data;
                })
                .catch((error) => {
                // Gérer les erreurs
                console.error(error);
                });
            },
             addMarques(fournisseur){
                this.fournisseurMarques = fournisseur.id;
                this.marqueAjoute = fournisseur;
                this.$nextTick(() => {
                    $('#addMarqueModal').modal('show');
                });    
            },
            submitMarque() {
                const marqueId = this.selectedMarqueId;
                const fournisseurId = this.marqueAjoute.id;
                axios.post(`/api/fournisseurMarques/${this.marqueAjoute.id}`, {
                    fournisseur_id: fournisseurId,
                    marque_id: marqueId,
                })
                .then(response => {
                    $('#addMarqueModal').modal('hide');
                    Swal.fire(
                        'Bon travail!', 
                        'Marque ajouté avec succès!',
                        'success'
                    );
                    console.log(response.data);
                    this.loadFournisseurs();
                    this.closeAddMarque();
                })
                .catch(({ response }) => {
                    Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ce fournisseur dispose déjà de cette marque!',
                });
                console.log(response.data);
                });
            },
            closeAddMarque(){
                this.loadMarques();
                // Fermer le modal de addMarques
                this.selectedMarqueId= '',
                $('#addMarqueModal').modal('hide');
            },
           
            closeShowMarques(){
                this.loadMarques();
                // Fermer le modal de showMarques
                $('#marques_modal').modal('hide');
            },

            newModal(){
                this.editMode = false;
                $('#add_modal').modal('show');
                
            },
            editModal(fournisseur){
                this.editMode = true;
                this.form.reset();
                this.form.fill(fournisseur);
                $('#add_modal').modal('show');
            },
            createFournisseur(){
                const fournisseur = {
                    name: this.form.name,
                    telephone: this.form.telephone ,
                    adresse: this.form.adresse,
                    type_id: this.form.type.id,
                    store_id: this.store_id,
                };

                this.$Progress.start();
                axios.post('api/fournisseur', fournisseur)
                .then((response)=>{
                        this.loadFournisseurs();
                        $('#add_modal').modal('hide');
                        Swal.fire(
                            'Bon travail!', 
                            'Fournisseur ajouté avec succès!',
                            'success'
                        );
                    })
                .catch((error)=>{
                    this.$Progress.fail();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Quelque chose n'a pas fonctionné!"
                    })
                    console.log(error);
                })

                // this.form.post('/api/fournisseur')
                // .then((response) => {
                // $('#add_modal').modal('hide');
                // Swal.fire(
                //     'Bon travail!', 
                //     'Fournisseur ajouté avec succès!',
                //     'success'
                // );
                // console.log(response.data);
                // this.loadFournisseurs();
                // })
                // .catch(({response}) => {
                // console.log(response.data);
                // });
            },
            closeAddModal(){
                $('#add_modal').modal('hide');
            },
            updateFournisseur(){
                this.form.put(`/api/fournisseur/${this.form.id}`)
                .then(() => {
                $('#add_modal').modal('hide');
                Swal.fire(
                    'Bon travail!',
                    'Fournisseur mise à jour avec succès!',
                    'success'
                );
                this.loadFournisseurs();
                })
                .catch(({response}) => {
                this.$toast.error(response.data.message);
                });
              },
       
           
            deleteFournisseur(id){
                                //Swal confirm
                Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Vous ne pourrez pas revenir en arrière!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText:'Oui, supprimez-le!',
                cancelButtonText: 'Annuler',
                }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/fournisseur/${id}`)
                    .then(() => {
                    this.loadFournisseurs();
                    Swal.fire(
                        'Supprimé!',
                        'Le fournisseur a été supprimé.',       
                        'success'
                    )
                    })
                    .catch(({response}) => {
                    console.log(response.data);
                    });
                }
                })
            },
     //Brand 
    showBrands(){
      $('#brandsModal').modal('show');
    },
    editBrand(brand){
      this.edit_brand = Object.assign({}, brand);
      brand.editing = true;
    },
    
    closeBrandModal(){
      this.edit_brand = {};
      this.editMode = false;
      this.BrandValidationErrors = {};
      $('#brandsModal').modal('hide');
    },
    saveEditBrand(){

      this.$Progress.start();
      axios.put(`/api/marque/${this.edit_brand.id}`,{
        name: this.edit_brand.name,
        description: this.edit_brand.description,
        logo: this.edit_brand.logo,
    })
      .then((response) => {
        console.log(response.data);
        //set editing false to all categories
        this.marques.forEach((brand) => {
          brand.editing = false;
        }
        
        );
        //find category by id
        const index = this.marques.findIndex((brand) => brand.id === this.edit_brand.id);
        this.loadMarques();
        // this.loadFournisseurs();
        this.$Progress.finish();  
        this.BrandValidationErrors = {};
        Swal.fire(
        'Bon travail!',
        'Marque mise à jour avec succès!',
        'success'
        );
      })
      .catch((error) => {
        console.log(error.response.data);
        this.BrandValidationErrors = error.response.data.errors;
        this.$Progress.fail();
      });
      },
      cancelEditBrand(brand){
      console.log(brand);
      this.edit_brand = {};
      this.BrandValidationErrors = {};
      brand.editing = false;
    },
    createBrand(){
      const isExist = this.marques.some((brand) => brand.name.toLowerCase() == this.brand_name.toLowerCase());
      if(this.brand_name == '' || isExist || !this.brand_name.trim()){
        let message = '';
        if(this.brand_name == '' || !this.brand_name.trim())
          message = 'Veuillez entrer le nom de la marque!';
        if(isExist)
          message = 'La catégorie portant ce nom existe déjà !';

        Swal.fire(
          'Error!',
          message,
          'error'
        );
        return;
      }

      this.$Progress.start();
      axios.post('/api/marque', {name: this.brand_name})
      .then((response) => {
        console.log(response.data);
        //push in sorted order
        this.loadMarques();
        this.brand_name = '';
        this.$Progress.finish();
        this.BrandValidationErrors = {};
        Swal.fire(
        'Bon travail!',
        'Marque ajoutée avec succès!',
        'success'
        );
      })
      .catch((error) => {
        this.$Progress.fail();
        console.log(error.response.data.errors);
        this.BrandValidationErrors = error.response.data.errors;
      });
    },
    deleteBrand(brand){
      Swal.fire({
        title: 'Êtes-vous sûr?',
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText:'Oui, supprimez-la!',
        cancelButtonText: 'Annuler',
      }).then((result) => {
        if (result.isConfirmed) {
          this.$Progress.start();
          let vm = this;
          axios.delete(`/api/marque/${brand.id}`)
          .then((response) => {
            console.log(response.data);
            vm.$Progress.finish();
            this.loadMarques();
            Swal.fire(
            'Supprimé!',
            'La marque a été supprimé.',  
            'success'
            );
          })
          .catch((error) => console.log(error));
        }
      })
    },
        }
    }
</script>
<style>
.icon-space {
    margin-left: 10px; /* Ajustez la valeur selon vos besoins */
}
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
.row.mt-3 .col input.form-control,
.row.mt-3 .col select.form-control {
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