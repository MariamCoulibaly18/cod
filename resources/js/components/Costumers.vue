<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-white">Clients</h3>
                        <div class="card-tools">
                            <div class="d-flex">
                                <!-- import excel-->
                                <button class="btn btn-light mr-2" @click="showImportModal" style="color: #01356F; ">
                                    Importer des clients(.xlsx)
                                    <i class="fas fa-file-import fa-fw"></i>
                                </button>
                                <button class="btn btn-light" @click="createModal"  style="color: #01356F;" >
                                    Nouveau <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
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
                                <select class="form-select" v-model="search.country">
                                    <option value="">Selectionner le pays</option>
                                    <option v-for="country in countries" :key="country.id" :value="country.id">{{country.name}}</option>
                                </select>
                            </div>

                            <div class="col">
                                <select class="form-select" v-model="search.isBlacklisted">
                                    <option value="">Sélectionnez l'option Liste noire</option>
                                    <option value="1">Sur liste noire</option>
                                    <option value="0">Sur liste blanche</option>
                                </select>
                            </div>    

                        </div>
                        <table class="table table-hover text-nowrap">
                            <div class="spinner-container" v-if="isLoading" style="top: 60%;transform: translate(-50%, -50%);">
                                <loader></loader>
                            </div>
                           <thead>
                                <th>ID</th>
                                <th>Nom complet</th>
                                <th>Email</th>
                                <th>Pays</th>
                                <th>Adresse</th>
                                <th>Telephone</th>
                                <th>
                                    Date de création
                                    <a @click="SortByDate" style="cursor:pointer">
                                        <i  class="fas fa-sort-up blue" v-if="this.search.date_sort_order === 'asc'"></i>
                                        <i class="fas fa-sort-down blue" v-if="this.search.date_sort_order === 'desc'"></i>
                                    </a>
                                </th>
                                <th>Actions</th>
                           </thead>
                           <tbody>
                                <tr v-if="!isLoading" v-for="client in paginatedClients" :key="client.id">
                                    <td>{{client.id}} </td>
                                    <td>{{client.billing['first_name']}} {{client.billing['last_name']}}</td>
                                    <td>{{client.email}}</td>
                                    <td>{{client.billing['country']}}</td>
                                    <td>{{client.billing['address_1']}}</td>
                                    <td>{{client.billing['phone']}}</td>
                                    <td>{{client.date_created | myDate}}</td>
                                    <td>
                                        <button class="btn btn-info btn" @click="editModal(client)">
                                            <i class="fas fa-edit fa-fw"></i>
                                        </button>
                                        <button class="btn btn-danger btn" @click="deleteClient(client)">
                                            <i class="fas fa-trash fa-fw"></i>
                                        </button>
                                        <button class="btn btn-danger btn" v-if="client.isBlacklisted">
                                            Liste noire
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
        <!-- Add and Edit Modal -->
        <div class="modal fade" id="add_modal" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 800px;">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editMode">Ajouter Client</h5>
                    <h5 class="modal-title" v-show="editMode">Modifier Client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode ? updateClient() : createClient()">
                    <div class="modal-body" >
                        <div class="container">   
                            <div class="row">
                                <!-- first name & last name-->
                                <div class="col-12 col-md-6">
                                    <label for="first_name">Prénom</label>
                                    <input type="text" class="form-control" :class="firstNameClass" v-model="form.first_name" placeholder="Prénom" >
                                    <!-- validation error -->
                                    <div class="invalid-feedback" v-show="validationErrors.first_name">
                                        {{validationErrors.first_name}}
                                    </div>
                                </div>     
                                <div class="col-12 col-md-6">
                                    <label for="last_name">Nom</label>
                                    <input type="text" class="form-control" v-model="form.last_name" placeholder="Nom" required  :class="lastNameClass">
                                    <!-- validation error -->
                                    <div class="invalid-feedback" v-show="validationErrors.last_name">
                                        {{validationErrors.last_name}}
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="col-md-12 mt-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" v-model="form.email" placeholder="Email" required  :class="emailClass">
                                    <!-- validation error -->
                                    <div class="invalid-feedback" v-show="validationErrors.email">
                                        {{validationErrors.email}}
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3" v-if="!$gate.isLocalStore()">
                                    <label for="motdepasse">Mot de passe</label>
                                    <input type="text" class="form-control" v-model="form.motdepasse" placeholder="Mot de passe">
                                </div>
                                <!-- Telephone -->
                                <div class="col-md-12 mt-3">
                                    <label for="telephone">Telephone</label>
                                    <input type="text" class="form-control" v-model="form.telephone" placeholder="Telephone"  required :class="telephoneClass">
                                    <!-- validation error -->
                                    <div class="invalid-feedback" v-show="validationErrors.telephone">
                                        {{validationErrors.telephone}}
                                    </div>
                                </div>
                                <!-- Country -->
                                <div class="col-md-12 mt-3">
                                    <label for="country">Pays</label>
                                    <select class="form-select" v-model="form.country" required >
                                        <option value='' selected>Choisir un pays</option>
                                        <option v-for="country in countries" :key="country.id" :value="country.id">{{country.name}}</option>
                                    </select>
                                    <!-- validation error -->
                                    <div class="invalid-feedback" v-show="validationErrors.country">
                                        {{validationErrors.country}}
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3" v-if="$gate.isLocalStore()">
                                    <label for="ville">Ville</label>
                                    <input class="form-control" v-model="form.ville" placeholder="Ville" >
                                </div>

                                <!-- Adresse -->
                                <div class="col-md-12 mt-3" >
                                    <label for="adresse">Adresse</label>
                                    <textarea class="form-control" v-model="form.adresse" placeholder="Adresse" required :class="adresseClass"></textarea>
                                    <!-- validation error -->
                                    <div class="invalid-feedback" v-show="validationErrors.adresse">
                                        {{validationErrors.adresse}}
                                    </div>
                                </div>
                            </div>                             
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-danger rounded-pill px-4" data-dismiss="modal" @click="closeModal">Annuler</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4" v-show="!editMode">Ajouter</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4" v-show="editMode">Modifier</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!-- Modal dialog for importing Excel -->
        <div class="modal" id="import_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Importer des clients sous format Excel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" @click="cancelImport">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- File input -->
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" :accept="['.xls', '.xlsx']" @change="importExcelFile" />
                                <label class="custom-file-label">
                                    <i class="fas fa-upload"></i> Télécharger un fichier
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger rounded-pill px-4" data-dismiss="modal" @click="cancelImport">Annuler</button>
                        <button type="button" class="btn btn-primary rounded-pill px-4" @click="submitImport">Envoyer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import axios from 'axios';
    export default {
        data(){
            return {
                clients:[],
                countries:[
                    {id:"BR",name:"Brasil"},
                    {id:"PT",name:"Portugal"},
                    {id:"ES",name:"España"},
                    {id:"FR",name:"France"},
                    {id:"MA",name:"Maroc"},
                ],
                editMode:false,
                form:new Form({
                    id:'',
                    first_name:'',
                    last_name:'',
                    email:'',
                    country:'',
                    adresse:'',
                    telephone:'',
                    motdepasse:'',
                    ville: '',
                }),
                validationErrors:{
                    first_name:'',
                    last_name:'',
                    email:'',
                    country:'',
                    adresse:'',
                    telephone:'',
                },
                search:{
                    name:'',
                    email:'',
                    country:'',
                    isBlacklisted:'',
                    date_sort_order:'desc',
                },
                //pagination
                pagination:{
                    current_page:1,
                    per_page:5,
                    total_pages:0,
                },
                store_id:null,
                excelFile:null,
                isLoading:true,
            }
        },
        created(){
            // get store from current boutique
            if(this.$store.getters.currentBoutique)
                this.store_id = this.$store.getters.currentBoutique.id;
            this.loadCustomers();
        },
        methods:{
             //pagination
            changePage(page){
                this.pagination.current_page = page;
                },
            loadCustomers(){
                axios.get(`api/customer/${this.store_id}`)
                .then(response => {
                    console.log(response.data);
                    this.clients = response.data;
                    this.isLoading = false;
                })
                .catch(error => {
                    console.log(error);
                })
            },
            createModal(){
                this.editMode = false;
                $('#add_modal').modal('show');
            },
            editModal(client){
                this.editMode = true;
                this.form.fill(client);
                this.form.telephone = client.billing['phone'];
                this.form.adresse = client.billing['address_1'];
                this.form.country = client.billing['country'];
                $('#add_modal').modal('show');
            },
            closeModal(){
                this.editMode = false;
                this.form.reset();
                this.form.clear();
                $('#add_modal').modal('hide');
            },
            createClient(){
                this.form.store = this.store_id;
                this.$Progress.start();
                this.form.post('api/customer')
                .then((response)=>{
                    console.log(response.data);
                    //load customers
                    this.loadCustomers();
                    //reset form
                    this.form.reset();
                    //delete store_id from form
                    delete this.form.store;
                })
                .then(()=>{
                    //finish progress bar
                    this.$Progress.finish();
                    //show success notification
                    Swal.fire({
                        icon: 'success',
                        title: 'Client ajouté avec succès.'
                    })
                    //close modal
                    $('#add_modal').modal('hide');
                    //delete store_id from form
                    delete this.form.store;
                })
                .catch((error)=>{
                    //failed progress bar
                    this.$Progress.fail();
                    //swal error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text:" Quelque chose n'a pas fonctionné!"
                    })
                    console.log(error.response.data.errors);
                    this.validationErrors = error.response.data.errors;
                })

                 
                
            },
            updateClient(){
                this.form.store = this.store_id;
                this.$Progress.start();
                this.form.put(`api/customer/${this.form.id}`)
                .then((response)=>{
                    console.log(response.data);
                    //load customers
                    this.loadCustomers();
                    //reset form
                    this.form.reset();  
                    //close modal
                    $('#add_modal').modal('hide');
                    //delete store from form
                    delete this.form.store;
                })
                .then(()=>{
                    //finish progress bar
                    this.$Progress.finish();
                    //show success notification
                    Swal.fire({
                        icon: 'success',
                        title: 'Client modifié avec succès.'
                    })

                })
                .catch((error)=>{
                    //failed progress bar
                    this.$Progress.fail();
                    //swal error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Quelque chose n'a pas fonctionné"
                    })
                    console.log(error.response.data.errors);
                    this.validationErrors = error.response.data.errors;
                })
                
            },
            deleteClient(client){
                //show confirmation modal
                Swal.fire({
                    title: 'Êtes-vous sûr?',
                    text: "Vous ne pourrez pas revenir en arrière!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimez-le!',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //start progress bar
                        this.$Progress.start();
                        axios.delete(`api/customer/${this.store_id}/${client.id}`)
                        .then((response)=>{
                            console.log(response.data);
                            this.loadCustomers();
                        })
                        .then(()=>{
                            //finish progress bar
                            this.$Progress.finish();
                            //show success notification
                            Swal.fire({
                                icon: 'success',
                                title: 'Client supprimé avec succès.'
                            })
                        })
                        .catch((error)=>{
                            //failed progress bar
                            this.$Progress.fail();
                            //swal error
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: "Quelque chose n'a pas fonctionné!"
                            })
                            console.log(error);
                        })
                       
                    }
                })
                
            },
            SortByDate(){
                this.search.date_sort_order = this.search.date_sort_order === 'asc' ? 'desc' : 'asc';
            },
            importExcelFile(event){
                this.excelFile = event.target.files[0];
            },
            showImportModal(){
                $('#import_modal').modal('show');
            },
            cancelImport(){
                this.excelFile = null;
                $('#import_modal').modal('hide');
            },
            submitImport(){
                this.$Progress.start();
                let formData = new FormData();
                formData.append('file',this.excelFile);
                formData.append('store',this.store_id);
                axios.post('api/customer/import',formData)
                .then((response)=>{
                    console.log(response.data);
                    this.loadCustomers();
                })
                .then(()=>{
                    this.$Progress.finish();
                    Swal.fire({
                        icon: 'success',
                        title: 'Clients importés avec succès.'
                    })
                    //this.excelFile = null;
                    $('#import_modal').modal('hide');
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
            },
            
        },
        computed:{
            paginatedClients(){
                this.pagination.total_pages = Math.ceil(this.filteredClients.length / this.pagination.per_page);
                return this.filteredClients.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
            },
            firstNameClass(){
                if(this.form.first_name === undefined || this.form.first_name == '')
                    return '';
                if(this.validationErrors.first_name !== undefined && this.validationErrors.first_name != '')
                    return 'est-invalide';
                return 'est-invalide';

            },
            lastNameClass(){
                if(this.form.last_name === undefined || this.form.last_name == '')
                    return '';
                if(this.validationErrors.last_name != '' && this.validationErrors.last_name !== undefined)
                    return 'est-invalide';
                return 'est-invalide';

            },
            emailClass(){
                if(this.form.email === undefined || this.form.email == '')
                    return '';
                if(this.validationErrors.email != '' && this.validationErrors.email !== undefined)
                    return 'est-invalide';
                return 'est-invalide';

            },
            adresseClass(){
                if(this.form.adresse === undefined || this.form.adresse == '')
                    return '';
                if(this.validationErrors.adresse != '' && this.validationErrors.adresse !== undefined)
                    return 'est-invalide';
                return 'est-invalide';

            },
            
            telephoneClass(){
                if(this.form.telephone === undefined || this.form.telephone == '')
                    return '';
                if(this.validationErrors.telephone != '' && this.validationErrors.telephone !== undefined)
                    return 'est-invalide';
                return 'est-invalide';

            },
            filteredClients(){
                let filtered = Object.values(this.clients);
                // let filtered = this.clients;
                //filter by full name
                if(this.search.name !== ''){
                    filtered = filtered.filter(client => 
                     client.billing.first_name.toLowerCase().includes(this.search.name.toLowerCase()) 
                     || client.billing.last_name.toLowerCase().includes(this.search.name.toLowerCase())
                    );
                }
                //filter by email
                if(this.search.email !=- ''){
                    filtered = filtered.filter(client => {
                        return client.email.toLowerCase().includes(this.search.email.toLowerCase());
                    })
                }

                //filter by country
                if(this.search.country !== ''){
                    filtered = filtered.filter(client => {
                        return client.billing['country'].toLowerCase().startsWith(this.search.country.toLowerCase());
                    })
                }

                //filter by blacklisted
                if(this.search.isBlacklisted !== ''){
                    filtered = filtered.filter(client => {
                        return client.isBlacklisted == this.search.isBlacklisted;
                    })
                }

                //sort by date
                filtered = filtered.sort((a,b) => {
                    if(this.search.date_sort_order == 'asc'){
                        return new Date(a.date_created) - new Date(b.date_created);
                    }else{
                        return new Date(b.date_created) - new Date(a.date_created);
                    }    
                })
                

                return filtered;
            }

        },
        watch:{
            'form.first_name':function(val){
                //regex pour vérifier le prenom contient que les lettres
                let regex = /^[a-zA-Z ]+$/;
                if(val.length == 0)
                    this.validationErrors.first_name = "";
                else{
                    if(!regex.test(val)){
                        this.validationErrors.first_name = "Le prenom doit contenir que les lettres";
                    }else{
                        if(val.length < 3){
                            this.validationErrors.first_name = "Le prenom doit contenir au moins 3 caractères";
                        }else{
                            this.validationErrors.first_name = "";
                        }
                    }
                }
            },
            'form.last_name':function(val){
                //regex pour vérifier le nom contient que les lettres
                let regex = /^[a-zA-Z ]+$/;
                if(val.length == 0)
                    this.validationErrors.last_name = "";
                else{
                    if(!regex.test(val)){
                        this.validationErrors.last_name = "Le nom doit contenir que les lettres";
                    }else{
                        if(val.length < 3){
                            this.validationErrors.last_name = "Le nom doit contenir au moins 3 caractères";
                        }else{
                            this.validationErrors.last_name = "";
                        }
                    }
                }
            },
            'form.email':function(val){
                //regex pour vérifier le format de l'email
                let regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                if(val.length == 0)
                    this.validationErrors.email = "";
                else{
                    if(!regex.test(val)){
                        this.validationErrors.email = "Le format de l'email est invalide";
                    }else{
                        this.validationErrors.email = "";
                    }
                }
            },
            'form.telephone':function(val){
                //doit etre 10 chiffres
                let regex = /^[0-9]{10}$/;
                if(val.length == 0)
                    this.validationErrors.telephone = "";
                else{
                    if(!regex.test(val)){
                        this.validationErrors.telephone = "Le numéro de téléphone doit contenir 10 chiffres";
                    }else{
                        this.validationErrors.telephone = "";
                    }
                }
            },
        },
        
     }
    
</script>
<style scoped>
.invalid-feedback{
    display:block;
    color: red;
}

.is-valid{
    border-color: green;
}
.is-invalid{
    border-color: red;
}
.custom-file-input {
  position: relative;
  display: inline-block;
}

.custom-file-input input[type="file"] {
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
  width: 100%;
  height: 100%;
  cursor: pointer;
}

.custom-file-input .button {
  display: inline-block;
  padding: 8px 16px;
  background-color: #337ab7; /* Customize the background color */
  color: #fff; /* Customize the text color */
  border-radius: 4px;
  cursor: pointer;
}

.custom-file-input .button i {
  margin-right: 8px;
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
</style>