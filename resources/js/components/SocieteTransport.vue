<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-white">Societe de transport</h3>
                        <div class="card-tools">
                            <button class="btn btn-light" @click="addSocieteTransport" style="color: #01356F;">
                              Nouveau <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="row mt-3">
                            <div class="col-8 mt-2 col-md-3">
                                <input type="text" class="form-control" placeholder="Nom" v-model="search.name">
                            </div>
                            <div class="col-8 mt-2 col-md-3">
                                <input type="text" class="form-control" placeholder="Adresse" v-model="search.adresse">
                            </div>
                        </div>
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Adresse</th>
                                <th>Telephone</th>
                                <th>Boutique</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <tr v-for="societeTransport in paginatedSocieteTransports" :key="societeTransport.id">
                                    <td >{{ societeTransport.id }}</td>
                                    <td>{{ societeTransport.name }}</td>
                                    <td>{{ societeTransport.adresse  }}</td>
                                    <td>{{ societeTransport.telephone}}</td>
                                    <td >{{ societeTransport.boutique.name }}</td>
                                    <td>
                                        <span v-if="!$store.getters.currentSocieteTransport || $store.getters.currentSocieteTransport.id != societeTransport.id">
                                            <button  class="btn btn-success" @click="enterSociete(societeTransport)">
                                            <i class='nav-icon fa-solid fa-people-carry-box fa-fw'></i>
                                            </button>
                                            <button @click="editSocieteTransport(societeTransport)" class="btn btn-info">
                                                <i class="fas fa-edit fa-fw"></i>
                                            </button>
                                            <button class="btn btn-danger" @click="deleteSocieteTransport(societeTransport.id)">
                                                <i class="fa fa-trash white"></i>
                                            </button>
                                        </span>
                                        <button v-else class="btn btn-danger" @click="quitSociete()"> <i class="fa fa-sign-out-alt white"></i></button>
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
        </div>
        <!-- Add Modal -->
        <div class="modal fade" id="addsocieteTransport" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" v-if="!editMode">Ajouter une société de transport</h5>
                <h5 class="modal-title" v-else>Modifier la société de transport</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" @click="closeAddModal()">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <!-- Form for adding/editing societeTransport -->
                <form id="societeTransport-form" @submit.prevent="editMode ? updateSocieteTransport() : createSocieteTransport()">
                  <div class="form-group">
                    <label for="store">Boutique:</label>
                    <a class="form-control">{{ boutique.name }}</a>
                  </div>
                  <div class="form-group">
                    <label for="product">Nom:</label>
                    <input type="text" class="form-control" id="name" v-model="form.name">
                  </div>
                  <div class="form-group">
                    <label for="product">Adresse:</label>
                    <input type="text" class="form-control" id="adresse" v-model="form.adresse">
                  </div>
                  <div class="form-group">
                    <label for="product">Telephone:</label>
                    <input type="number" class="form-control" id="telephone" v-model="form.telephone">
                  </div>
                  
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger rounded-pill px-4" data-bs-dismiss="modal"> Annuler</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" v-if="!editMode"> Ajouter</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" v-if="editMode"> Modifier</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

 </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
      return {
          societeTransports: [],
          livreurs:[],
          boutiques: [],
          boutique: '',
          editMode: false,
          store_id: null,
          livreurAjoute:0,
          errors: [],
          form: new Form({
              id:'',
              name: '',
              adresse: '',
              telephone: '',
              livreur:[],
              boutique:{
                  id:'',
                  name:'',
              },
          }),
          search : {
          name:'',
          adresse:'',
      },
      //pagination
    pagination:{
      current_page:1,
      per_page:5,
      total_pages:0,
    },
      }
  },
  computed : {
    paginatedSocieteTransports(){
        this.pagination.total_pages = Math.ceil(this.filteredSociete.length / this.pagination.per_page);
        return this.filteredSociete.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
     },
    filteredSociete(){
        // Filtrer par nom
        let filtered = Object.values(this.societeTransports);
        if (this.search.name !== '') {
            filtered = filtered.filter(societeTransport =>
            societeTransport.name.toLowerCase().includes(this.search.name.toLowerCase())
        );
        }
      // Filtrer par adresse
      if (this.search.adresse !== '') {
            filtered = filtered.filter(societeTransport =>
            societeTransport.adresse.toLowerCase().includes(this.search.adresse.toLowerCase())
        );
        }

      return filtered;
    }
},
  created(){
    // get store from current boutique
    if(this.$store.getters.currentBoutique)
      this.store_id = this.$store.getters.currentBoutique.id;
    // loadProducts
    this.loadsocieteTransports();
    //this.loadsocieteTransports();
    // this.loadbrands();
  },
  methods:{
     //pagination
     changePage(page){
         this.pagination.current_page = page;
        },
    enterSociete(societeTransport){
      
      axios.get(`/api/societeTransport/${societeTransport.id}/connect`)
        .then((response) => {
          console.log(response);
          this.$store.commit('switchSocieteTransport', societeTransport);
        })
        .catch(({response}) => {
          Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: response.data.error,
            });
        });
        return ; 
        //this.$router.push({name:'orders'});
    },
    quitSociete(){
        this.$store.commit('switchSocieteTransport', null);
        this.$router.push({name:'societe-transport'});
    },
  
      loadsocieteTransports(){
          axios.get(`api/societeTransport/${this.store_id}`)
          .then(({data}) => {
            (this.societeTransports = data.societeTransport);
            (this.boutique = data.boutique);
            })
          .catch(({response}) => console.log(response.data));
      },
      showLivreurs(societeTransport){
        $('#livreurs_modal').modal('show');
                // Appeler l'API pour récupérer les livreurs de la societe de transport
                axios.get(`/api/livreur/${societeTransport.id}`)
                .then((response) => {
                // Récupérer la liste des livreurs depuis la réponse de l'API
                this.livreurs = response.data;
                })
                .catch((error) => {
                // Gérer les erreurs
                console.error(error);
                });
      },
      closeShowLivreurs(){
        $('#livreurs_modal').modal('hide');
      },
      addLivreurs(societeTransport){
                this.livreurAjoute = societeTransport;
                this.$nextTick(() => {
                    $('#addlivreurModal').modal('show');
                });    
            },
            submitlivreur() {
                const societeTransport_id = this.livreurAjoute.id;
                axios.post(`/api/livreur/${this.livreurAjoute.id}`,{
                    societeTransport_id: societeTransport_id,
                    name: this.livreurForm.name,
                    prenom: this.livreurForm.prenom,
                    telephone: this.livreurForm.telephone,
                    adresse: this.livreurForm.adresse,
                    status: this.livreurForm.status,
                    matricule: this.livreurForm.matricule,
                }) 
                .then(response => {
                        $('#addlivreurModal').modal('hide');
                Swal.fire(
                    'Bon travail!',
                    'livreur ajouté avec succès!',
                    'success'
                );
                console.log(response.data);
                this.loadsocieteTransports();
                this.closeAddlivreur();
                })
                .catch(({response}) => {
                console.log(response.data);
                });
            },
            closeAddlivreur(){
                // Fermer le modal de addlivreurs
                this.livreurForm.name = '',
                this.livreurForm.prenom= '',
                this.livreurForm.adresse = '',
                this.livreurForm.telephone= '',
                this.livreurForm.matricule = '',
                this.livreurForm.status= '',
                $('#addlivreurModal').modal('hide');
            },
           
  addSocieteTransport(){
      this.editMode = false;
      this.resetForm();
      $('#addsocieteTransport').modal('show');
    },
  editSocieteTransport(societeTransport){
      this.editMode = true;
      //console.log(product);
    //   this.ProductValidationErrors = {};
    this.fillForm(societeTransport);
      $('#addsocieteTransport').modal('show');
    },
    resetForm(){
      this.form = {
        id:'',
              name: '',
              adresse: '',
              telephone: '',
              boutique:{
                  id:'',
                  name:'',
              },
            }
    },
    createSocieteTransport() {
    // Créez un objet contenant les données de la societeTransport à envoyer
    const societeTransportData = {
      boutique_id: this.boutique.id,
      name: this.form.name,
      telephone: this.form.telephone,
      adresse: this.form.adresse,
    };
    this.$Progress.start();
    axios.post('/api/societeTransport', societeTransportData)
    .then((response) => {
      console.log(response.data);
      this.loadsocieteTransports();
      this.$Progress.finish();
      Swal.fire(
      'Bon travail',
      'Société Transport ajoutée avec succès!',
      'success'
      );
      $('#addsocieteTransport').modal('hide');
    })
    .catch((error) =>{
      this.$Progress.fail();
      console.log(error);
    });
  },


  closeAddModal(){
      $('#addsocieteTransport').modal('hide');
  },

  deleteSocieteTransport(id){
      
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
            axios.delete(`/api/societeTransport/${id}`)
            .then(() => {
            this.loadsocieteTransports();
            Swal.fire(
                'Supprimé!',
                'La societé de transport  a été supprimée.',
                'success'
            )
            })
            .catch(({response}) => {
            console.log(response.data);
            });
        }
      })
  },
  fillForm(societeTransport){
      this.form = {
      id: societeTransport.id,
        boutique_id: societeTransport.boutique_id,
      name: societeTransport.name,
      telephone: societeTransport.telephone,
      adresse: societeTransport.adresse,
      }
    },
  updateSocieteTransport(){
    const societeTransportData = {
        id: this.form.id,
      boutique_id: this.boutique.id,
      name: this.form.name,
      telephone: this.form.telephone,
      adresse: this.form.adresse,
    };
      this.$Progress.start();
      axios.put(`api/societeTransport/${societeTransportData.id}`,societeTransportData)
      .then((response) => {
        console.log(response.societeTransport);
        this.loadsocieteTransports();
        this.$Progress.finish();
        Swal.fire(
        'Bon travail!',
        'Société de Transports mise à jour avec succès!',
        'success'
        );
        $('#addsocieteTransport').modal('hide');
      })
      .catch((error) => {
        this.$Progress.fail();
        if(error.response.status == 422){
          console.log(this.errors);
        }  
      });
    },
}
}
</script>
<style>
.icon-space {
    margin-left: 10px; 
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
.row.mt-3 .col-8 input.form-control,
.row.mt-3 .col-8 select.form-control {
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