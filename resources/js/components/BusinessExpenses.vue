<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-white">Depenses de l'entreprise</h3>
                        <div class="card-tools">
                            <button class="btn btn-light" @click="newModal"  style="color: #01356F; " >
                                Nouveau <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="row mt-3">
                            <div class="col-8 mt-2 col-md-3">
                                <select class="form-select" style="font-size:13px" v-model="search.category">
                                    <option value="">Categorie de depense</option>
                                    <option v-for="team_category in categorys" :key="team_category.id" :value="team_category.id">{{team_category.titre}}</option>
                                </select>
                            </div>
                            <!-- Status-->
                            <div class="col-8 mt-2 col-md-3">
                                <select class="form-select" style="font-size:13px" v-model="search.status">
                                <option value="">Status</option>
                                <option v-for="status in statusList" :key="status" :value="status">{{ status }}</option>
                                </select>
                            </div>
                        </div>
                        <table class="table table-hover text-nowrap">
                            <div class="spinner-container" v-if="isLoading" style="top: 50%;transform: translate(-50%, -50%);">
                              <loader></loader>
                            </div>
                            <thead>
                                <th>Ref</th>
                                <th>Categorie</th>
                                <th>Montant</th>
                                <th>Date</th>
                                <th>Note</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                <tr  v-if="!isLoading" v-for="businessExpense in paginatedBusinessExpenses" :key="businessExpense.id">
                                    <td >{{ businessExpense.id }}</td>
                                    <td >{{ businessExpense.category.titre }}</td>
                                    <td>{{ businessExpense.montant }}</td>
                                    <td>{{ businessExpense.date }}</td>
                                    <td>{{ businessExpense.note }}</td>
                                    <td>
                                        <span
                                            :class="{
                                                'status-red': businessExpense.status === 'canceled',
                                                'status-yellow': businessExpense.status === 'pending',
                                                'status-green': businessExpense.status === 'approved'
                                            }"
                                            style="display: inline-block; border: 1px solid; padding: 5px;"
                                        >
                                            {{ businessExpense.status }}
                                        </span>
                                    </td>                       
                                    <td>
                                        <button @click="editModal(businessExpense)" class="btn btn-info">
                                                <i class="fas fa-edit fa-fw"></i>
                                        </button>
                                        <button class="btn btn-danger" @click="deleteBusinessExpense(businessExpense.id)">
                                            <i class="fa fa-trash white"></i>
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
        <div class="modal fade" id="add_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editMode">Ajouter une depense professionnelle</h5>
                    <h5 class="modal-title" v-show="editMode">Modifier la depense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" @click="closeAddModal()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode ? updateBusinessExpense() : createBusinessExpense()">
                    <div class="modal-body">
                        <div class="container">   
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <div class="form-group">
                                        <label for="store">Boutique:</label>
                                        <a class="form-control">{{ boutique.name }}</a>
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Categorie</label>
                                        <select v-model="form.category_id" class="form-select" :class="{ 'is-invalid': form.errors.has('category.id') }">
                                            <option value="">Categorie</option>
                                            <option v-for="categoryDepense in categorys" :key="categoryDepense.id" :value="categoryDepense.id">{{categoryDepense.titre}}</option>
                                        </select>
                                    </div>
                                
                                <div class="form-group">
                                    <label for="montant">Montant</label>
                                    <input type="number" class="form-control" id="montant" placeholder="Entrer le montant" v-model="form.montant">       
                                </div>
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control" id="date" placeholder="Entrer la date" v-model="form.date">       
                                </div>
                                <div class="form-group">
                                    <label for="category">Status</label>
                                    <select class="form-select" v-model="form.status">
                                    <option value="">Status</option>
                                    <option v-for="status in statusList" :key="status" :value="status">{{ status }}</option>
                                    </select>
                                    <span class="text-danger" v-if="form.status === ''">Veuillez sélectionner un statut</span>
                                </div>
                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <textarea class="form-control" id="note" rows="5" placeholder="Votre note" v-model="form.note"></textarea>
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

 </div>
</template>
<script>
import axios from "axios";
    export default {
        data() {
            return {
                businessExpenses: [],
                store_id:null,
                errors: [],
                boutique:[],
                categorys:[],
                statusList: ['pending', 'approved', 'canceled'],
                form: new Form({
                    id: '',
                    montant: 0,
                    date: '',
                    note: '',
                    status: '',
                    category_id: '',
                    boutique_id: '',
                    category:{
                        id:'',
                        titre:'',
                        parent:'',
                    },
                    boutique:{
                        id:'',
                        name:'',
                    },
                    user:{
                        id:'',
                        name:'',
                    },
                  
                }),
                search:{
                    status: '',
                    category:'',
                },
               //pagination
                pagination:{
                    current_page:1,
                    per_page:5,
                    total_pages:0,
                },
                isLoading:true,
                editMode: false,
                BrandValidationErrors: {},
            }
        },
        computed:{ 
            paginatedBusinessExpenses(){
                this.pagination.total_pages = Math.ceil(this.filteredBusinessExpense.length / this.pagination.per_page);
                return this.filteredBusinessExpense.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
                },
            filteredBusinessExpense() {
                let filtered = Object.values(this.businessExpenses);
                // Filtrer par catégories
                if (this.search.category !== '') {
                    filtered = filtered.filter(teamExpense =>
                    teamExpense.category.id == this.search.category
                    );
                }
                if (this.search.status && this.search.status !== '') {
                    filtered = filtered.filter((teamExpense) => {
                        return teamExpense.status.toLowerCase().includes(this.search.status.toLowerCase());
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
        this.loadBusinessExpenses();
        this.loadCategoryDepense();
        // this.loadbrands();
    },
    methods:{
        //pagination
        changePage(page){
         this.pagination.current_page = page;
        },
        loadBusinessExpenses() {
            axios
                .get(`api/businessExpense/${this.store_id}`)
                .then((response) => {
                    // La réponse de l'API est accessible via response.data
                    console.log(response.data.businessExpenses);
                    this.businessExpenses = response.data.businessExpenses;
                    this.boutique = response.data.boutique;
                    this.isLoading = false;

                })
                .catch((error) => console.log(error));
        },
        loadCategoryDepense() {
            axios
                .get('api/categoryExpenses')
                .then((response) => {
                    // La réponse de l'API est accessible via response.data
                    console.log(response.data.categoryBusinessExpenses);
                    this.categorys = response.data.categoryBusinessExpenses;
                })
                .catch((error) => console.log(error));
        },
        
        newModal(){
                this.editMode = false;
                this.form.reset();
                $('#add_modal').modal('show');
            },
            editModal(businessExpense){
                this.editMode = true;
                this.form.reset();
                this.form.fill(businessExpense);
                $('#add_modal').modal('show');
            },
            createBusinessExpense(){
                const businessExpenseData = {
                boutique_id: this.boutique.id,
                category_id: this.form.category_id,
                montant: this.form.montant,
                date: this.form.date,
                status: this.form.status,
                note: this.form.note
                };
                this.$Progress.start();
                axios.post('/api/businessExpense', businessExpenseData)
                .then((response) => {
                console.log(response.data);
                this.loadBusinessExpenses();
                this.$Progress.finish();
                Swal.fire(
                'Bon travail!',
                'Dépense ajoutée avec succès!',
                'success'
                );
                $('#add_modal').modal('hide');
                })
                .catch((error) =>{
                this.$Progress.fail();
                console.log(error);
                });
            },
            closeAddModal(){
                $('#add_modal').modal('hide');
            },
            updateBusinessExpense(){
                this.form.put(`/api/businessExpense/${this.form.id}`)
                .then(() => {
                $('#add_modal').modal('hide');
                Swal.fire(
                    'Bon travail!',
                    'Dépense mise à jour avec succès !',
                    'success'
                );
                this.loadBusinessExpenses();
                })
                .catch(({response}) => {
                this.$toast.error(response.data.message);
                });
              },
              deleteBusinessExpense(id){
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
                    axios.delete(`/api/businessExpense/${id}`)
                    .then(() => {
                    this.loadBusinessExpenses();
                    Swal.fire(
                        'Supprimée!',
                        'La depense a été supprimée.',
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
.status-red {
    background-color: rgb(238, 180, 180);
    color: rgb(75, 4, 4);
    display: inline-block; 
    border: 1px solid rgb(75, 4, 4); 
    padding: 5px;
    border-radius: 5px; 
    border-style: dashed;
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
.row.mt-3 .col input.form-control,
.row.mt-3 .col select.form-control {
  font-size: 13px; 
}
</style>