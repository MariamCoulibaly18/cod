<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #2f4fb1; display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
                        <h3 class="card-title text-white">Depenses de l'equipe</h3>
                        <div class="card-tools">
                            <div class="dropdown">
                                <button @click="showDropdown" class="btn btn-light" style="color: #01356F;">
                                    Nouveau <i class="ti ti-plus"></i>
                                </button>
                            </div>
                         </div>

                    </div>
                    <div class="card-body table-responsive p-0">
                        <div class="row mt-3 mx-2">
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
                            <div v-if="isDropdownVisible" class="provided">
                               <div style="font-weight: bold"><i class="fa fa-question-circle orange" aria-hidden="true"></i>
                                     Ces dépenses sont-elles prises en charge par votre entreprise ou par un membre ?</div>
                                    <button  v-for="(provided, index) in provideds" :key="'provided-button-' + index" @click="handleProvidedClick(provided)"
                                    :class="{'provided-blue': provided.name === 'Fournis par mon entreprise','provided-button': provided.name === 'Fourni par un membre' }">
                                                {{ provided.name }} 
                                    </button>
                                </div>
                        <table class="table table-hover text-nowrap">
                            <div class="spinner-container" v-if="isLoading" style="top: 50%;transform: translate(-50%, -50%);">
                              <loader></loader>
                            </div>
                            <thead>
                                <th>Ref</th>
                                <th>Categorie</th>
                                <th>Membre</th>
                                <th>Montant</th>
                                <th>Date</th>
                                <th>Note</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                <tr v-if="!isLoading" v-for="teamExpense in paginatedTeamExpenses" :key="teamExpense.id">
                                    <td >{{ teamExpense.id }}</td>
                                    <td >{{ teamExpense.category.titre }}</td>
                                    <td :style="{ color: teamExpense.category.parent_category_id ==2 }">
                                        <span v-if="teamExpense.category.parent_category_id ==1" style="font-weight: bold">De:</span>
                                        <span v-else style="font-weight: bold">Pour:</span>
                                        {{  teamExpense.user.name }}
                                    </td>
                                    <td :style="{ color: teamExpense.category.parent_category_id ==2 ? 'green' : 'red' }">
                                        <span v-if="teamExpense.category.parent_category_id ==1" style="font-weight: bold">-</span>
                                        <span v-else style="font-weight: bold">+</span>
                                        {{ teamExpense.montant }}
                                    </td>
                                    <td>{{ teamExpense.date }}</td>
                                    <td>{{ teamExpense.note }}</td>
                                    <td>
                                        <span
                                            :class="{
                                                'status-red': teamExpense.status === 'canceled',
                                                'status-yellow': teamExpense.status === 'pending',
                                                'status-green': teamExpense.status === 'approved'
                                            }"
                                            style="display: inline-block; border: 1px solid; padding: 5px;"
                                        >
                                            {{ teamExpense.status }}
                                        </span>
                                    </td>
                                    <td>
                                        <button  class="btn btn-info"  @click="editModal(teamExpense)">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" @click="deleteTeamExpense(teamExpense.id)">
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
        <!-- Add and Edit Modal -->
        <div class="modal fade" id="add_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editMode">Ajouter une depense de l'equipe</h5>
                    <h5 class="modal-title" v-show="editMode">Modifier depense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" @click="closeAddModal()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode ? updateTeamExpense() : createTeamExpense()">
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
                                        <select v-model="form.category_id" class="form-control" :class="{ 'is-invalid': form.errors.has('category.id') }">
                                            <option value="">Categorie </option>
                                            <option v-for="categoryDepense in categorys" :key="categoryDepense.id" :value="categoryDepense.id">{{categoryDepense.titre}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="user">Fourni par</label>
                                        <select v-model="form.user_id" class="form-control" :class="{ 'is-invalid': form.errors.has('user.id') }">
                                            <option value="">Membre </option>
                                            <option v-for="user in users" :key="user.id" :value="user.id">{{user.name}}</option>
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
                        <button type="button" class="btn btn-danger" data-dismiss="modal" @click="closeAddModal()">Fermer</button>
                        <button type="submit" class="btn btn-primary" v-show="!editMode">Ajouter</button>
                        <button type="submit" class="btn btn-primary" v-show="editMode">Modifier</button>
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
            provideds: [],
            users: [],
            boutique: [],
            selectedProvided: null,
            isDropdownVisible: false,
            teamExpenses: [],
            editMode: false,
            isLoading:true,
            store_id:null,
            errors: [],
            categorys:[],
            statusList: ['pending', 'approved', 'canceled'],
            form: new Form({
                id: '',
                montant: 0,
                date: '',
                note: '',
                status: '',
                category_id: '',
                selectedCategory: '',
                // categorys: [],
                boutique_id: '',
                provided_id: '',
                user_id: '',
                category:{
                    id:'',
                    titre:'',
                    parent_category_id: '',
                    parentCategory:{
                        id: '',
                        name: '',
                    }
                },
                provided:{
                    id:'',
                    name:'',
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
            showAlert: false,
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
                }
        
    },
    computed:{ 
        paginatedTeamExpenses(){
            this.pagination.total_pages = Math.ceil(this.filteredTeamExpense.length / this.pagination.per_page);
            return this.filteredTeamExpense.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
            },
        filteredTeamExpense() {
            let filtered = Object.values(this.teamExpenses);
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
    this.loadteamExpenses();
    this.showProvideds();
    this.loadUsers();
    this.loadCategoryDepense();
},
methods:{
        //pagination
    changePage(page){
        this.pagination.current_page = page;
    },
    loadteamExpenses() {
        axios
            .get(`api/teamExpense/${this.store_id}`)
            .then((response) => {
                // La réponse de l'API est accessible via response.data
                console.log(response.data.teamExpenses);
                this.teamExpenses = response.data.teamExpenses;
                this.boutique = response.data.boutique;
                this.isLoading = false;
            })
            .catch((error) => console.log(error));
    },
    loadUsers(){
        axios.get('/api/user')
        .then((response) => {
        console.log(response.data);
        this.users = response.data.data;
        })
        .catch(({response}) => console.log(response.data));
    },
    showProvideds() {
        axios.get('/api/provided')
        .then(response => {
            this.provideds = response.data.provideds;
            this.selectedProvided = null; // Réinitialiser la sélection du fournisseur
        })
        .catch(error => {
            console.error(error);
        });
    },
    loadCategoryDepense() {
        axios
            .get('api/categoryExpenses')
            .then((response) => {
                // La réponse de l'API est accessible via response.data
                console.log(response.data.categoryTeamExpenses);
                this.categorys = response.data.categoryTeamExpenses;
            })
            .catch((error) => console.log(error));
    },
    loadCategoryProvided() {
        if (this.selectedProvided) {
        this.form.provided_id = this.selectedProvided.id;
        const CategoryData = {
            fourni_id: this.form.provided_id,
        };
        axios
            .post('api/providedCategory',CategoryData)
            .then((response) => {
                // La réponse de l'API est accessible via response.data
                this.categorys = response.data.categoryTeamExpenses;
                console.log(this.categorys);
                // this.form.category_id = '';
            })
            .catch((error) => console.log(error));
        }
    },
    showDropdown() {
        this.isDropdownVisible = !this.isDropdownVisible;
        // this.showAlert = true;
        },
        handleProvidedClick(provided) {
            this.selectedProvided= provided;
            this.loadCategoryProvided();
            this.editMode = false;
            this.form.reset();
            this.isDropdownVisible = false;
            $('#add_modal').modal('show');
        },
        editModal(teamExpense){
            this.editMode = true;
            this.form.reset();
            this.form.fill(teamExpense);
            $('#add_modal').modal('show');
        },
    createTeamExpense(){
        this.form.provided_id= this.selectedProvided.id;
        const teamExpenseData = {
            boutique_id: this.boutique.id,
            category_id: this.form.category_id,
            user_id: this.form.user_id,
            provided_id: this.form.provided_id,
            montant: this.form.montant,
            date: this.form.date,
            status: this.form.status,
            note: this.form.note
            };
            this.$Progress.start();
            axios.post('/api/teamExpense', teamExpenseData)
            .then((response) => {
            console.log(response.data);
            this.loadteamExpenses();
            this.loadCategoryDepense();
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

    updateTeamExpense(){
        this.form.put(`/api/teamExpense/${this.form.id}`)
            .then(() => {
            $('#add_modal').modal('hide');
            Swal.fire(
                'Bon travail!',
                'Dépense mise à jour avec succès !',
                'success'
            );
            this.loadteamExpenses();
            })
            .catch(({response}) => {
            this.$toast.error(response.data.message);
            });
    },
    closeAddModal(){
        this.loadCategoryDepense();
        $('#add_modal').modal('hide');
        },
    deleteTeamExpense(id){
            Swal.fire({
            title: 'Êtes-vous sûr?',
            text: "Vous ne pourrez pas revenir en arrière!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3b3f5c',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimez-la!',
            cancelButtonText: 'Annuler'
            }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`/api/teamExpense/${id}`)
                .then(() => {
                this.loadteamExpenses();
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
        searchByCategorys(){
            console.log(this.search.selectedCategory);
            if(this.search.selectedCategory !== undefined){
                if(this.search.selectedCategory == 'all'){
                this.search.categorys = [];
                return;
                }  
                this.search.categorys.push(this.search.selectedCategory);
            }

            },
            selectCategory(){
            if(this.form.selectedCategory !== '' && this.form.selectedCategory !== undefined){
                this.form.categories.push(this.form.selectedCategory);
                this.form.selectedCategory = '';
            }
            },
            unSelectCategory(index){
            this.form.categories.splice(index, 1);
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
.dropdown {
  position: relative;
  display: inline-block;
}

/* .btn {
  background-color: #28a745;
  color: #fff;
  border: none;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  line-height: 1.5;
  cursor: pointer;
} */
.provided {
  position: absolute;
  top: 50px; /*  définir la distance par rapport au haut de la page */
  right: 0; /*définir l'emplacement horizontal */
  background-color: rgba(255, 255, 255, 0.985);
  border-radius: 5px;
  border-width: 1px;
  padding: 5px;
  z-index: 999;
}


.provided-button {
  background-color: #559ee8;
  margin-bottom: 10px; 
  padding:5px; 
  border-radius: 5px;
  border-width: 1px;
  border-color: #559ee8;
  color: white;
  margin-right: 5px;

}
.provided-blue{
    background-color: white;
    border-color: white;
    color: #559ee8;
    margin-bottom: 10px; 
    padding: 5px; 
    margin-right: 5px;
    border-radius: 5px;
    border-width: 1px;

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