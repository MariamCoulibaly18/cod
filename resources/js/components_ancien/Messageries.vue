<template>
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header" style="background-color: #2f4fb1; display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
              <h3 class="card-title text-white">Messagerie</h3>
              <div class="card-tools">
                <button class="btn btn-light" @click="newModal"  style="color: #01356F;">
                  Nouveau <i class="ti ti-plus"></i>
                </button>
              </div>
            </div>
            <div class="card-body table-responsive p-0">
               <div class="row mt-3 mx-2">
                 <div class="col-8 mt-2 justify-content-center col-md-3">
                     <input type="text" class="form-control" style="font-size:13px" placeholder="titre messagerie "  v-model="search.titre" />
                  </div>
                 <!-- Status meaagerie-->
                 <div class="col-8 mt-2 col-md-3">
                    <select class="form-select" style=" font-size: 13px" v-model="search.status_messagerie">
                       <option value="">Status</option>
                       <option v-for="status in statusMessagerieList" :key="status" :value="status">{{ status }}</option>
                      </select>
                  </div>
               </div>
                 <table class="table table-hover text-nowrap">
                  <div class="spinner-container" v-if="isLoading" style="top: 50%;transform: translate(-50%, -50%);">
                    <loader></loader>
                  </div>
                     <thead>
                         <th>Titre</th>
                         <th>Modèle</th>
                         <th>Api Messagerie</th>
                         <th>Status</th>
                         <th>Actions</th>
                     </thead>
                     <tbody>
                         <tr v-if="!isLoading" v-for="messagerie in paginatedMessageries" :key="messagerie.id">
                            <td >{{ messagerie.titre }}</td>
                            <td>{{ messagerie.template.titre }}</td>
                            <td>{{ messagerie.api_messagerie.api_name }}</td>
                            <td>
                                <span
                                :class="{
                                  'status-yellow': messagerie.status_messagerie === 'en attente',
                                  'status-green': messagerie.status_messagerie === 'en cours'
                                    }"
                                  style="display: inline-block; border: 1px solid; padding: 5px;"
                                  >
                                  {{ messagerie.status_messagerie }}
                                </span>
                            </td>
                            <td>
                              <button  class="btn btn-info"  @click="editModal(messagerie)">
                                <i class="ti ti-edit"></i>
                              </button>
                              <button class="btn btn-danger" @click="deleteMessagerie(messagerie.id)">
                                  <i class="ti ti-trash-x"></i>
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
  
      <!-- Modal for adding/editing a record -->
        <div class="modal fade custom-overlay" id="add_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" v-show="!editMode">Ajouter</h5>
                  <h5 class="modal-title" v-show="editMode">Modifier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" @click="CloseModal">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form  @submit.prevent="editMode ? updateMessagerie() : createMessagerie()">
                <div class="modal-body">
                <div class="row" >
                    <div class="col-lg-6 mt-3">
                        <label class="col-sm-2 col-form-label">Titre</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="form.titre" />
                        </div>
                    </div>
                    <div class="col-lg-6 mt-3">
                        <label class="col-sm-2 col-form-label">Envoyer a</label>
                        <div class="col-sm-10">
                          <select v-model="form.recepteur" class="form-select" :class="{ 'is-invalid': form.errors.has('recepteur.id') }">
                              <option value="">Envoyer a</option>
                              <option v-for="recepteur in recepteurList" :key="recepteur" :value="recepteur">{{recepteur}}</option>
                           </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                        <div class="col-lg-6 mt-3">
                        <label class="col-sm-2 col-form-label" for="template">Modèle</label>
                        <div class="col-sm-10 d-flex align-items-center">
                          <select v-model="form.template_id" class="form-select" :class="{ 'is-invalid': form.errors.has('template.id') }">
                              <option value="">Modèle </option>
                              <option v-for="template in templates" :key="template.id" :value="template.id">{{template.titre}}</option>
                           </select>
                           <button type="button" class="btn btn-primary ml-2" @click="openTemplateModal">
                              <i class="ti ti-plus" style="font-size: 20px;"></i>
                           </button>
                        </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                        <label class="col-sm-2 col-form-label" for="apiMessagerie">API Messagerie</label>
                        <div class="col-sm-10 d-flex align-items-center">
                          <select v-model="form.api_messagerie_id" class="form-select" :class="{ 'is-invalid': form.errors.has('apiMessagerie.id') }">
                              <option value="">API Messagerie </option>
                              <option v-for="apiMessagerie in apiMessageries" :key="apiMessagerie.id" :value="apiMessagerie.id">{{apiMessagerie.api_name}}</option>
                           </select>
                           <button type="button" class="btn btn-primary ml-2" @click="openApiMessagerieModal">
                              <i class="ti ti-plus" style="font-size: 20px;"></i>
                          </button>
                        </div>
                        </div>
                 </div>

                 <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="col-sm-2 col-form-label">Status Messagerie</label>
                        <div class="col-sm-10">
                          <select v-if="!editMode" disabled class="form-select" v-model="form.status_messagerie">
                            <option value="en cours">en cours</option>
                          </select>
                          <select v-else class="form-select" v-model="form.status_messagerie">
                            <option v-for="status in statusMessagerieList" :key="status" :value="status">{{ status }}</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-sm-2 col-form-label">Status Livraison</label>
                        <div class="col-sm-10 d-flex align-items-center">
                          <select v-model="form.statut_livraison_id" class="form-select" :class="{ 'is-invalid': form.errors.has('statutLivraison.id') }">
                              <option value="">Statut Livraison </option>
                              <option v-for="statutLivraison in statusLivraisons" :key="statutLivraison.id" :value="statutLivraison.id">{{statutLivraison.status}}</option>
                           </select>
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="CloseModal">Annuler</button>
                <button type="submit" class="btn btn-primary" v-show="!editMode">Ajouter</button>
                <button type="submit" class="btn btn-primary" v-show="editMode">Modifier</button>
                </div>
              </form>
            </div>
            </div>
        </div>
  
      <!-- Modal for adding a Template -->
        <div class="modal fade template-modal-style" id="templateModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeTemplateModal">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="col-lg-6 mt-3">
                    <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Titre</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" v-model="templateform.titre" />
                    </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Texte</label>
                    <div class="col-sm-8">
                        <i class="fa fa-sliders" aria-hidden="true" style="margin-left:220px; cursor: pointer;" @click="afficherList"></i>
                        <textarea class="form-control" id="texte" rows="3" column="8" placeholder="Votre texte" v-model="templateform.texte" @input="updateApercu"></textarea>
                    </div>
                    </div>

                </div>
                <div class="col-lg-6 mt-3">
                    <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Apercu</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" id="texte" rows="5" column="8" placeholder="Vous verrez ici un aperçu de votre message" style="background-color: #E2E6EA;"  v-model="templateform.apercu" readonly :style="{ height: apercuHeight + 'px' }"></textarea>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="addTemplate">Ajouter</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeTemplateModal">Annuler</button>
            </div>
                  <!-- Select caché -->
                  <div v-if="showList" >
                <ul class="select-dropdown">
                 <li class="dropdown-item" v-for="option in selectOptions" @click="selectOption(option)">{{ option }}</li>
                </ul>
             </div>
            </div>
         
        </div>
        </div>

  
      <!-- Modal for adding/editing an API Messagerie -->
      <div class="modal fade" id="apiMessagerieModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeApiMessageModal">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-lg-6 mt-3">
                      <div class="form-group">
                          <label for="api_name">Nom</label>
                          <input type="text" class="form-control" id="api_name" v-model="apiMessagerieform.api_name" />
                      </div>
                      <div class="form-group">
                          <label for="api_key">Clé Api</label>
                          <input type="text" class="form-control" id="api_key" v-model="apiMessagerieform.api_key" />
                      </div>
                      <div class="form-group">
                          <label for="api_secret">Clé secrète</label>
                          <input type="text" class="form-control" id="api_secret" v-model="apiMessagerieform.api_secret" />
                      </div>
                  </div>
                  <div class="col-lg-6 mt-3">
                      <div class="form-group">
                          <label for="comment">Comment configurer Vonage SMS</label>
                          <div id="comment" rows="5" columns="8" placeholder=" " style="background-color: #E2E6EA; border-radius: 5px;  padding: 5px;">
                            1- S'inscrire dans l'application <a href="https://ui.idp.vonage.com/ui/auth/login" target="_blank">Vonage SMS</a>
                            <br>
                            2- Copier et coller API Key
                            <br>
                            3- Copier et coller API Secret
                          </div>
                      </div>
                  </div>
              </div>
          </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="addApiMessagerie">Ajouter</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeApiMessageModal">Annuler</button>
            </div>
            </div>
         
        </div>
      </div>
  
    </div>
  </template>
  
  <script>
import axios from 'axios';

  export default {
    data() {
      return {
        editMode: false,
        form:new Form({
          id: '',
          titre: '',
          recepteur: '',
          boutique_id: '',
          template_id: '',
          api_messagerie_id: '',
          status_messagerie: 'en cours',
          statut_livraison_id: '',
          template: {
            titre: '',
            texte: '',
          },
          apiMessagerie: {
            api_name: '',
            api_key: '',
            api_secret: '',
          },
          statutLivraison: {
            status: '',
          },
        }
        ), 
        templateform:new Form({
          titre: '',
          texte: '',
        }
        ),
        apiMessagerieform:new Form({
          api_name: '',
          api_key: '',
          api_secret: '',
        }),
        statusMessagerieList:['en cours', 'en attente'],
        recepteurList:['Client', 'Fournisseur', 'Societe de transport'],
        store_id: '',
        messageries: [],
        boutique: '',
        templates: [],
        apiMessageries: [],
        statusLivraisons: [],
        showList: false,
        activeDropdownIndex: false,
        isLoading:true,
        selectOptions: [ // Options du select
                'Nom client',
                'Numero client',
                'Ville client',
                'Reference commande',
                'Prix total commande',
                "Numero liveur",
                'Nom livreur',
            ],
            apercuHeight: 20, // Taille initiale de l'aperçu (en pixels)
             //pagination
             pagination:{
                    current_page:1,
                    per_page:5,
                    total_pages:0,
                },
             search:{
                titre: '',
                status_messagerie:'',
                template: '',
               },
      };
    },
    computed:{ 
            paginatedMessageries(){
                this.pagination.total_pages = Math.ceil(this.filteredMessagerie.length / this.pagination.per_page);
                return this.filteredMessagerie.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
                },
            filteredMessagerie() {
                let filtered = Object.values(this.messageries);
                // Filtrer par catégories
                if (this.search.titre && this.search.titre !== '') {
                    filtered = filtered.filter((messagerie) => {
                        return messagerie.titre.toLowerCase().includes(this.search.titre.toLowerCase());
                    });
                    }
                if (this.search.status_messagerie && this.search.status_messagerie !== '') {
                   filtered = filtered.filter((messagerie) => {
                        return messagerie.status_messagerie.toLowerCase().includes(this.search.status_messagerie.toLowerCase());
                    });
                 }
                return filtered;
                },
        },
    created(){
    // get store from current boutique
    if(this.$store.getters.currentBoutique)
      this.store_id = this.$store.getters.currentBoutique.id;
    // loadProducts
    this.loadMessageries();
    this.loadTemplates();
    this.loadApiMessageries();
    this.loadStatutLivraison();
  },
    methods: {
        //pagination
        changePage(page){
          this.pagination.current_page = page;
        },
        loadMessageries(){
          axios
                .get(`api/messagerie/${this.store_id}`)
                .then((response) => {
                    // La réponse de l'API est accessible via response.data
                    console.log(response.data.messageries);
                    this.messageries = response.data.messageries;
                    this.boutique = response.data.boutique;
                    this.isLoading = false;
                })
                .catch((error) => console.log(error));
        },
        loadTemplates(){
            axios.get('api/template/')
            .then((response =>{
                console.log(response.data.templates);
                this.templates= response.data.templates;
                if (this.form.template_id) {
                  const selectedTemplate = this.templates.find(template => template.id === this.form.template_id);
                  if (selectedTemplate) {
                      this.templateform = new Form({
                          titre: selectedTemplate.titre,
                          texte: selectedTemplate.texte,
                      });
                  }
                }
            }))
            .catch((error) => console.log(error));
        },
        loadApiMessageries(){
            axios.get('api/apiMessagerie/')
            .then((response =>{
                console.log(response.data.apiMessageries);
                this.apiMessageries= response.data.apiMessageries;
                if (this.form.api_messagerie_id) {
                  const selectedApiMessageries = this.apiMessageries.find(apiMessagerie => apiMessagerie.id === this.form.api_messagerie_id);
                  if (selectedApiMessageries) {
                      this.apiMessagerieform = new Form({
                        api_name: selectedApiMessageries.api_name,
                        api_key: selectedApiMessageries.api_key,
                        api_secret: selectedApiMessageries.api_secret,
                      });
                  }
                }
            }))
            .catch((error) => console.log(error));
        },
        loadStatutLivraison(){
            axios.get('api/statutLivraison/')
            .then((response =>{
                console.log(response.data.statusLivraisons);
                this.statusLivraisons= response.data.statusLivraisons;
            }))
            .catch((error) => console.log(error));
        },
        addTemplate(){
            const templateData={
                titre: this.templateform.titre,
                texte: this.templateform.texte,
            };
            this.$Progress.start();
            axios.post('/api/template', templateData)
            .then((response) => {
                console.log(response.data);
                this.loadTemplates();
                this.$Progress.finish();
                this.form.template_id = response.data.id; // Définir l'ID du modèle sélectionné dans le formulaire
                $('#templateModal').modal('hide');
              })
             .catch((error) =>{
                this.$Progress.fail();
                console.log(error);
             });
        },
        addApiMessagerie(){
            const apiMessagerieData={
                api_name: this.apiMessagerieform.api_name,
                api_key: this.apiMessagerieform.api_key,
                api_secret: this.apiMessagerieform.api_secret,
            };
            this.$Progress.start();
            axios.post('/api/apiMessagerie', apiMessagerieData)
            .then((response) => {
                console.log(response.data);
                this.loadApiMessageries();
                this.$Progress.finish();
                this.form.api_messagerie_id = response.data.id; // Définir l'ID du modèle sélectionné dans le formulaire
                $('#apiMessagerieModal').modal('hide');
              })
             .catch((error) =>{
                this.$Progress.fail();
                console.log(error);
             });
        },
      
        afficherList() {
            this.showList = !this.showList; // Inverse la valeur de la variable showList
        },
        selectOption(option) {
          const formattedOption = option.toLowerCase().replace(/ /g, '_');
          this.templateform.texte += ' ' + `{{${formattedOption}}}`; // Ajoute l'option sélectionnée au texte existant
          this.updateApercu(); // Met à jour l'aperçu directement avec la valeur réelle
          this.showList = false; // Masque le select après avoir sélectionné une option
        },
        updateApercu() {
          let previewText = this.templateform.texte;
          const regex = /{{(.*?)}}/g;
          const matches = previewText.match(regex);

          if (matches) {
              matches.forEach(match => {
                  const option = match.substring(2, match.length - 2).trim();
                  // Remplace l'option entre accolades par sa valeur réelle (vous devez définir un objet ou un dictionnaire qui mappe les options aux valeurs réelles)
                  previewText = previewText.replace(match, this.optionToValue(option));
              });
          }
          // Mettre à jour l'aperçu avec le texte modifié
          this.templateform.apercu = previewText;
           // Calculer la hauteur de l'aperçu en fonction de la taille du texte
            const previewTextarea = document.getElementById('texte');
            this.apercuHeight = Math.max(previewTextarea.scrollHeight, 20); 
        },
        optionToValue(option) {
            // Mappez chaque option à sa valeur réelle ici (exemple avec des options fictives)
            const optionValues = {
              'nom_client': 'mariam',
              'numero_client':'0689435678',
              'ville_client':'Casablanca',
              'reference_commande':'RF009',
              'prix_total_commande': '1500dh',
              "numero_livreur": '0756432189',
              'nom_livreur': 'Ines',
            };
            return optionValues[option] || ''; // Renvoie la valeur réelle ou une chaîne vide si l'option n'a pas de valeur définie
        },
        newModal() {
          // Réinitialiser les champs du formulaire
          this.editMode = false;
          this.form.reset();
          // Ouvrir le modal
          $("#add_modal").modal("show");
        },
        editModal(messagerie){
                this.editMode = true;
                this.form.reset();
                this.form.fill(messagerie);
                $('#add_modal').modal('show');
            },
        CloseModal(){
            $("#add_modal").modal("hide");
        },
      openTemplateModal() {
        $("#templateModal").modal("show");
      },
      closeTemplateModal(){
        $("#templateModal").modal("hide");
      },
      openApiMessagerieModal() {
        $("#apiMessagerieModal").modal("show");
      },
      closeApiMessageModal(){
        $("#apiMessagerieModal").modal("hide");
      },
      createMessagerie(){
            const messagerieData = {
                boutique_id: this.boutique.id,
                api_messagerie_id: this.form.api_messagerie_id,
                template_id: this.form.template_id,
                statut_livraison_id: this.form.statut_livraison_id,
                status_messagerie: this.form.status_messagerie,
                titre: this.form.titre,
                recepteur: this.form.recepteur,
                };
                this.$Progress.start();
                axios.post('/api/messagerie', messagerieData)
                .then((response) => {
                console.log(response.data);
                this.loadMessageries();
                this.$Progress.finish();
                Swal.fire(
                'Bon travail!',
                'Messagerie ajoutée avec succès!',
                'success'
                );
                $('#add_modal').modal('hide');
                })
                .catch(({ response }) => {
                  if (response.status === 421) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Le statut de livraison existe déjà pour cette boutique!',
                    });
                } 
                else {
                    console.log(response.data);
                }
                });
        },
        updateMessagerie(){
            this.form.put(`/api/messagerie/${this.form.id}`)
                .then(() => {
                $('#add_modal').modal('hide');
                Swal.fire(
                    'Bon travail!',
                    'Messagerie mise à jour avec succès!',
                    'success'
                );
                this.loadMessageries();
                })
                .catch(({response}) => {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Le statut de livraison existe déjà pour cette boutique!',
                });
                this.$toast.error(response.data.message);
                });
        },
        deleteMessagerie(id){
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
                    axios.delete(`/api/messagerie/${id}`)
                    .then(() => {
                    this.loadMessageries();
                    Swal.fire(
                        'Supprimée!',
                        'La messagerie a été supprimée.',
                        'success'
                    )
                    })
                    .catch(({response}) => {
                    console.log(response.data);
                    });
                }
                })
            },
    },
  };
  </script>
  <style>
  .template-modal-style {
    margin-top: 1rem;
  }
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Couleur grise semi-transparente pour l'overlay */
    z-index: 1050; 
  }
  .select-dropdown {
  position: absolute;
  top: 173px; /*  définir la distance par rapport au haut de la page */
  right: auto;
  left: 32%;
  background-color: white;
  border-color: black;
  border-style:solid;
  border-radius: 8px;
  border-width: 1px;
  padding: 5px;
  box-shadow: black;
  z-index: 999;
}

.select-dropdown.show {
  opacity: 1;
  pointer-events: auto;
}

.dropdown-item {
  padding: 0px ;
  color: black;
  text-decoration: none;
  display: block;
  font-size: smaller;
}

.dropdown-item:hover {
  background-color: #dce1e7;
  border-radius: 5px;
}
.status-yellow {
    background-color: rgb(244, 216, 179);
    display: inline-block; 
    border: 1px solid rgb(128, 98, 0); 
    color: rgb(128, 98, 0);
    padding: 5px;
    border-radius: 5px; 
    border-style: dashed;
}

.status-green {
    display: inline-block; 
    border: 1px solid green ; 
    color: green;
    background-color: rgb(220, 243, 220); 
    padding: 5px;
    border-radius: 5px; 
    border-style: dashed;
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
</style>
