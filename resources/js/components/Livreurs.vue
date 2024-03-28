<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-white">Livreur</h3>
                        <div class="card-tools">
                            <button class="btn btn-light"  @click="addLivreur()"  style="color: #01356F;" >
                              Nouveau <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="row mt-3">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Nom" v-model="search.name">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Adresse" v-model="search.adresse">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Matricule" v-model="search.matricule">
                            </div>
                        </div>
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Adresse</th>
                                <th>Telephone</th>
                                <th>Matricule</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <tr v-for="livreur in paginatedLivreurs" :key="livreur.id">
                                    <td >{{ livreur.id }}</td>
                                    <td>{{ livreur.user.name }}</td>
                                    <td>{{ livreur.adresse  }}</td>
                                    <td>{{ livreur.telephone}}</td>
                                    <td>{{ livreur.matricule}}</td>
                                    <td>
                                            <button @click="editlivreur(livreur)" class="btn btn-info">
                                                <i class="fas fa-edit white"></i>
                                            </button>
                                            <button class="btn btn-danger" @click="deletelivreur(livreur.id)">
                                                <i class="fa fa-trash white"></i>
                                            </button>
                                            <button class="btn btn-warning" @click="showLivreurCommandeDetails(livreur)">
                                              <i class="nav-icon fas fa-shopping-cart" style="color: #ffffff;"></i>
                                            </button>
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

        <div class="modal fade" id="livreurModal" tabindex="-1" role="dialog"  aria-labelledby="livreurModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 v-if="!editMode" class="modal-title" id="livreurModalLabel">Ajouter livreur</h5>
                <h5 v-if="editMode" class="modal-title" id="livreurModalLabel">Modifier livreur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" @click="closeAddModal()">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <!-- Form for adding/editing livreur -->
                <form id="livreur-form" @submit.prevent="editMode ? updatelivreur() : createlivreur()">
                    <div class="form-group">
                      <label for="id">Societe de transport :</label>
                      <a class="form-control">{{ societeTransport.name }}</a>
                    </div>
                    <div class="form-group">
                      <label >Nom utilisateur</label>
                        <select v-model="form.user.id" type="text" id="user" name="user"
                            class="form-control">
                            <option value="">Selectionner une utilisateur</option>
                            <option v-for="user in users" :key="user.id" :value="user.id">{{user.name}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="adresse">Adresse</label>
                      <input type="text" class="form-control" id="adresse" v-model="form.adresse">       
                    </div>
                    <div class="form-group">
                      <label for="telephone">Telephone</label>
                      <input type="number" class="form-control" id="telephone"  v-model="form.telephone">       
                    </div>
                    <div class="form-group">
                      <label for="matricule">Matricule</label>
                      <input type="text" class="form-control" id="matricule" v-model="form.matricule">       
                    </div>
                  <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger rounded-pill px-4" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" v-if="!editMode">Ajouter</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" v-if="editMode">Modifier</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
         <!-- detail modal-->
          <div v-if="livreurCommandeDetails" class="modal fade" id="livreurCommandeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="livreurCommandeDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="livreurCommandeDetailsModalLabel">Commandes assignées Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeDetailsModal">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <table class="table table-hover text-nowrap">
                            <thead>
                                <th>ID</th>
                                <th>CommandeId</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                <tr v-for="livreur_commande in livreurCommandes" :key="livreur_commande.id">
                                    <td >{{ livreur_commande.id }}</td>
                                    <td>{{ livreur_commande.order_id }}</td>
                                    <td>
                                      <template v-if="livreur_commande.accepted === 0">
                                        En attente
                                      </template>
                                      <template v-else-if="livreur_commande.accepted === 1">
                                        Accepté
                                      </template>
                                      <template v-else>
                                        Refusé
                                      </template>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>    
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger rounded-pill px-4" data-dismiss="modal" @click="closeDetailsModal">Fermer</button>
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
    livreurs: [],
    users: [],
    societeTransports:[],
    societeTransport: '',
    livreurCommandes:[],
    livreurCommandeDetails:[],
    editMode: false,
    societeTransport_id: null,
    statusList: ['Disponible', 'Non Disponible'],
    errors: [],
    form: {
      id: '',
      adresse: '',
      telephone: '',
      matricule: '',
      societeTransport: {
        id: '',
        name: '',
      },
      user: {
        id: '',
        name: '',
      },
    },
    search: {
      name: '',
      adresse: '',
      matricule: '',
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
    paginatedLivreurs(){
        this.pagination.total_pages = Math.ceil(this.filteredlivreurs.length / this.pagination.per_page);
        return this.filteredlivreurs.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
     },
    filteredlivreurs() {
      let filtered = Object.values(this.livreurs);

      if (this.search.name !== '') {
        filtered = filtered.filter(livreur =>
          livreur.user.name.toLowerCase().includes(this.search.name.toLowerCase())
        );
      }

      if (this.search.adresse !== '') {
        filtered = filtered.filter(livreur =>
          livreur.adresse.toLowerCase().includes(this.search.adresse.toLowerCase())
        );
      }

      if (this.search.matricule !== '') {
        filtered = filtered.filter(livreur =>
          livreur.matricule.toLowerCase().includes(this.search.matricule.toLowerCase())
        );
      }

      return filtered;
    },
},
  created(){
    // get store from current boutique
    if(this.$store.getters.currentSocieteTransport)
      this.societeTransport_id = this.$store.getters.currentSocieteTransport.id;
    
      this.loadlivreurs();
    
  },
  mounted(){
    this.loadUsers();
  },
  methods:{
     //pagination
     changePage(page){
         this.pagination.current_page = page;
        },
        loadlivreurs() {
            axios
                .get(`/api/livreur/${this.societeTransport_id}`)
                .then((response) => {
                const { data } = response;
                this.livreurs = data.livreur;
                this.societeTransport = data.societeTransport;
                console.log(this.livreurs);
                })
                .catch((error) => {
                console.log(error);
                });
            },

      loadUsers(){
        if(!this.$gate.isSuperAdmin())
            return ;

        axios.get('api/user')
        .then(({data}) => {
        this.users = data.data.filter(user => user.type === 'livreur');
        console.log(this.users);
        })
        .catch(({response}) => {
        console.log(response.data);
        });
    },
    resetForm(){
      this.form = {
        id:'',
        adresse: '',
        telephone: '',
        livreurCommandes:[],
        // status:null,
        matricule:'',
        societeTransport:{
         id:'',
         name:'',
         },  
          user:{
              id:'',
              name:'',
         },        
       }
    },
    addLivreur(){
        this.editMode = false;
        this.resetForm();
        $('#livreurModal').modal('show');
      },
      editlivreur(livreur){
      this.editMode = true;
      this.fillForm(livreur);
      console.log(this.form);
      $('#livreurModal').modal('show');
    },
    createlivreur() {
        // Créez un objet contenant les données du livreur à envoyer
        const livreurData = {
            adresse: this.form.adresse,
            telephone: this.form.telephone,
            matricule: this.form.matricule,
            societeTransport_id: this.societeTransport.id,
            user_id: this.form.user.id,
        };
        console.log(livreurData);
        this.$Progress.start();

        axios
            .post('/api/livreur', livreurData)
            .then((response) => {
            console.log(response.data);
            this.loadlivreurs();
            this.$Progress.finish();
            Swal.fire(
            'Bon travail!', 
            'livreur a été ajouté avec succès!',
            'success');
            $('#livreurModal').modal('hide');
            })
            .catch((error) => {
            this.$Progress.fail();
            console.log(error);
            });
        },


  closeAddModal(){
      $('#livreurModal').modal('hide');
  },

  deletelivreur(id){
      
      //Swal confirm
      Swal.fire({
        title: 'Êtes-vous sûr?',
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3b3f5c',
        cancelButtonColor: '#d33',
        confirmButtonText:'Oui, supprimez-la!',
        cancelButtonText: 'Annuler',
      }).then((result) => {

        if (result.isConfirmed) {
            axios.delete(`/api/livreur/${id}`)
            .then(() => {
            this.loadlivreurs();
            Swal.fire(
                'Supprimé!',
                'Le livreur a été supprimé.',
                'success'
            )
            })
            .catch(({response}) => {
            console.log(response.data);
            });
        }
      })
  },
  fillForm(livreur){
    this.form.id = livreur.id;
    this.form.adresse = livreur.adresse;
    this.form.telephone = livreur.telephone;
    this.form.matricule = livreur.matricule;
    this.form.societeTransport.id = livreur.societeTransport_id;
    this.form.user.id = livreur.user_id;
    //   status: livreur.status,
    },
   
    updatelivreur(){
    const livreurData = {
      societeTransport_id: this.form.societeTransport.id,
      telephone: this.form.telephone,
      adresse: this.form.adresse,
      matricule: this.form.matricule,
      user_id: this.form.user.id,
    //   status: this.form.status,
    };
      this.$Progress.start();
      axios.put(`api/livreur/${this.form.id}`,livreurData)
      .then((response) => {
        console.log(response.livreur);
        this.loadlivreurs();
        this.$Progress.finish();
        Swal.fire(
        'Bon travail!',
        'Livreur mise à jour avec succès!',
        'success'
        );
        $('#livreurModal').modal('hide');
      })
      .catch((error) => {
        this.$Progress.fail();
        if(error.response.status == 422){
          console.log(this.errors);
        }  
      });
    },
    showLivreurCommandeDetails(livreur) {
      this.livreurCommandeDetails = livreur;
      this.$nextTick(() => {
        $('#livreurCommandeDetailsModal').modal('show');
        axios.get('api/livreurCommande/')
          .then(({ data }) => {
            this.livreurCommandes = data.data.filter(commande => commande.livreur_id === this.livreurCommandeDetails.id);
            console.log(this.livreurCommandeDetails);
          })
          .catch(({ response }) => console.log(response.data));
      });
    },
    closeDetailsModal() {
          this.livreurCommandeDetails = null;
          $('#livreurCommandeDetailsModal').modal('hide');
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