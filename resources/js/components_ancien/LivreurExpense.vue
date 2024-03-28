<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #2f4fb1; display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
                        <h3 class="card-title text-white">Depenses du livreur</h3>
                        <div class="card-tools">
                            <div class="dropdown">
                                <button class="btn btn-light"  @click="newModal"  style="color: #01356F; " >
                                    Nouveau <i class="ti ti-plus"></i>
                                </button>
                            </div>
                         </div>

                    </div>
                    <div class="card-body table-responsive p-0">
                        <div class="row mt-3 mx-2">
                            <div class="col-8 mt-2 col-md-3">
                                <input type="text" class="form-control" style="font-size:13px" placeholder="Mot-clé" >
                            </div>
                            <div class="col-8 mt-2 col-md-3">
                                <select class="form-select" style="font-size:13px" v-model="search.category">
                                    <option value="">Categorie</option>
                                    <option v-for="livreur_category in livreurCategorys" :key="livreur_category.id" :value="livreur_category.id">{{livreur_category.titre}}</option>
                                </select>
                            </div>
                        </div>
                        <table class="table table-hover text-nowrap">
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
                                <tr v-if="!isLoading" v-for="livreurExpense in paginatedLivreurExpenses" :key="livreurExpense.id">
                                    <td >{{ livreurExpense.id }}</td>
                                    <td >{{ livreurExpense.category.titre }}</td>
                                    <td style="font-weight: bold">
                                        {{ livreurExpense.montant }}
                                    </td>
                                    <td>{{ livreurExpense.date }}</td>
                                    <td>{{ livreurExpense.note }}</td>
                                    <td>
                                        <span
                                            :class="{
                                                'status-red': livreurExpense.status === 'canceled',
                                                'status-yellow': livreurExpense.status === 'pending',
                                                'status-green': livreurExpense.status === 'approved'
                                            }"
                                            style="display: inline-block; border: 1px solid; padding: 5px;"
                                        >
                                            {{ livreurExpense.status }}
                                        </span>
                                    </td>
                                    <td>
                                        <button  class="btn btn-info"  @click="editModal(livreurExpense)">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="spinner-container" v-if="isLoading">
                                  <loader></loader>
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
                    <h5 class="modal-title" v-show="!editMode">Ajouter une depense du livreur</h5>
                    <h5 class="modal-title" v-show="editMode">Modifier depense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" @click="closeAddModal()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode ? updateLivreurExpense() : createLivreurExpense()">
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
                                            <option v-for="categoryDepense in livreurCategorys" :key="categoryDepense.id" :value="categoryDepense.id">{{categoryDepense.titre}}</option>
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
import DropdownButton from './Dropdown.vue'; // Assurez-vous que le chemin est correct
    export default {
        components: {
            DropdownButton
        },
        data() {
            return {
                provideds: [],
                user: [],
                boutique: [],
                selectedProvided: null,
                isDropdownVisible: false,
                livreurExpenses: [],
                editMode: false,
                isLoading:true,
                store_id:null,
                errors: [],
                livreurCategorys:[],
                statusList: ['pending', 'approved', 'canceled'],
                form: new Form({
                    id: '',
                    montant: 0,
                    date: '',
                    note: '',
                    status: 'pending',
                    category_id: '',
                    selectedCategory: '',
                    // livreurCategorys: [],
                    boutique_id: '',
                    provided_id: 2,
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
            paginatedLivreurExpenses(){
                this.pagination.total_pages = Math.ceil(this.filteredLivreurExpense.length / this.pagination.per_page);
                return this.filteredLivreurExpense.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
                },
            filteredLivreurExpense() {
                let filtered = Object.values(this.livreurExpenses);
                // Filtrer par catégories
                if (this.search.category !== '') {
                    filtered = filtered.filter(livreurExpense =>
                    livreurExpense.category.id == this.search.category
                    );
                }
                if (this.search.status && this.search.status !== '') {
                    filtered = filtered.filter((livreurExpense) => {
                        return livreurExpense.status.toLowerCase().includes(this.search.status.toLowerCase());
                    });
                    }
                return filtered;
                },
        },
    created(){
        this.loadLivreurExpenses();
        this.loadCategoryDepense();
    },
    methods:{
          //pagination
        changePage(page){
            this.pagination.current_page = page;
        },
        loadLivreurExpenses() {
            axios
                .post('api/expenseLivreur/')
                .then((response) => {
                    // La réponse de l'API est accessible via response.data
                    console.log(response.data.boutique);
                    console.log(response.data.user);
                    this.livreurExpenses = response.data.livreurExpenses;
                    this.boutique = response.data.boutique;
                    this.user = response.data.user;
                    this.isLoading = false;
                })
                .catch((error) => console.log(error));
        },
        loadCategoryDepense() {
            axios
                .get('api/categoryExpenses')
                .then((response) => {
                    // La réponse de l'API est accessible via response.data
                    console.log(response.data.livreurCategorys);
                    this.livreurCategorys = response.data.livreurCategorys;
                })
                .catch((error) => console.log(error));
        },
            newModal(){
                this.editMode = false;
                this.form.reset();
                $('#add_modal').modal('show');
            },
            editModal(livreurExpense){
                this.editMode = true;
                this.form.reset();
                this.form.fill(livreurExpense);
                $('#add_modal').modal('show');
            },
        createLivreurExpense(){
            this.form.user_id=this.user.id;
            const LivreurExpenseData = {
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
                axios.post('/api/teamExpense', LivreurExpenseData)
                .then((response) => {
                console.log(response.data);
                this.loadLivreurExpenses();
                this.loadCategoryDepense();
                this.$Progress.finish();
                Swal.fire(
                'Bon travail!',
                'Dépense ajoutée avec succès !',
                'success'
                );
                $('#add_modal').modal('hide');
                })
                .catch((error) =>{
                this.$Progress.fail();
                console.log(error);
                });
        },

        updateLivreurExpense(){
            this.form.put(`/api/teamExpense/${this.form.id}`)
                .then(() => {
                $('#add_modal').modal('hide');
                Swal.fire(
                    'Bon travail!',
                    'Dépense mise à jour avec succès !',
                    'success'
                );
                this.loadLivreurExpenses();
                })
                .catch(({response}) => {
                this.$toast.error(response.data.message);
                });
        },
        closeAddModal(){
            this.loadCategoryDepense();
            $('#add_modal').modal('hide');
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
</style>