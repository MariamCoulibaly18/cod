<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-white">Categorie</h3>
                        <div class="card-tools">
                        <!-- button pour ajouter new brand-->
                        <button @click="addModal()" class="btn btn-light"  style="color: #01356F;"  >
                            Nouveau <i class="fa-solid fa-plus"></i>
                        </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <!-- search bar as container and every input is a column -->
                        <div class="row mt-3 ">
                        <div class="col-4">
                            <input type="text" class="form-control" style="font-size:13px" placeholder="Nom" v-model="search.name">
                        </div>
                        </div>
                        <table class="table table-hover text-nowrap">
                        <div class="spinner-container" v-if="isLoading" style="top: 60%;transform: translate(-50%, -50%);">
                            <loader></loader>
                        </div>
                        <thead>
                            <th>   
                                <!-- <input type="checkbox" v-model="form.allCase"> -->
                                <div class="n-chk align-self-center text-center">
                                <div class="form-check" >
                                    <input  type="checkbox"
                                    class="form-check-input primary"
                                    id="contact-check-all"
                                    v-model="form.allCase"
                                    @change="selectAllCases"
                                    />
                                    <label class="form-check-label" for="contact-check-all"></label>
                                    <span class="new-control-indicator"></span>
                                </div>
                                </div>
                            </th>
                            <th>Nom</th>
                            <th  v-if="!$gate.isLocalStore()" >Description</th>
                            <th  v-if="!$gate.isLocalStore()" >Slug</th>
                            <th  v-if="!$gate.isLocalStore()" >Total Produit</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            <tr v-if="!isLoading" v-for="categorie in paginatedCategories" :key="categorie.id">
                                <td>
                                    <!-- <input type="checkbox" v-model="categorie.case"> -->
                                    <div class="n-chk align-self-center text-center">
                                    <div class="form-check">
                                        <input type="checkbox"
                                        class="form-check-input contact-chkbox primary"
                                        :id="'checkbox_' + categorie.id"
                                        :value="categorie.id"
                                        :checked="selectedCategorieIds.includes(categorie.id)"
                                        @change="selectIndividualCase(categorie.id)"
                                        />
                                        <label class="form-check-label" :for="'checkbox_' + categorie.id"></label>
                                    </div>
                                    </div>
                                </td>
                                <td>{{ categorie.name |  upText  }}</td>
                                <td  v-if="!$gate.isLocalStore()" >{{ categorie.description ? categorie.description : '—' }}</td>
                                <td  v-if="!$gate.isLocalStore()" >{{ categorie.slug }}</td>
                                <td  v-if="!$gate.isLocalStore()" >{{ categorie.count }}</td>
                                <td>
                                <button class="btn btn-info btn" @click="editModal(categorie)">
                                    <i class="fa-solid fa-edit fa-fw"></i>
                                </button>
                                <button class="btn btn-danger btn" v-if="categorie.id != currentCategorie.id"  @click="deleteCategorie(categorie.id)">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div> 
                    <div class="card-footer d-flex justify-content-center"> 
                        <div class="col-md-6 mb-3 d-flex align-items-center">
                            <div class="d-flex justify-content-center">
                                <select class="form-select me-2" v-model="actionGrouper">
                                <option value="" selected>Actions groupées</option>
                                <option value="supprimer">Supprimer</option>
                                </select>
                                <button type="button" class="btn btn-outline-info m-1" @click="applyAction">Appliquer</button>
                            </div>
                        </div>
                        <div v-if="!isLoading" class="col-md-6 d-flex justify-content-end">
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
        </div>        
        <!-- Modal -->
        <div class="modal fade" id="AddnewModal" tabindex="-1" aria-labelledby="AddnewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddnewModalLabel" v-if="!editMode">Ajouter une nouvelle categorie</h5>
                        <h5 class="modal-title" id="AddnewModalLabel" v-if="editMode">Modifier la categorie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="editMode ? updateCategorie() : createCategorie()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="form-label">Nom</label>
                                <input v-model="form.name" type="text" name="name"
                                placeholder="Nom"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div  v-if="!$gate.isLocalStore()"  class="form-group">
                                <label class="form-label">Slug</label>
                                <input v-model="form.slug" type="text" name="slug" placeholder="slug" class="form-control" >
                            </div>
                            <div  v-if="!$gate.isLocalStore()"  class="form-group">
                                <label for="categorieParent" class="form-label">Categorie parent :</label>
                                <select class="form-select" v-model="form.categorieParent">
                                    <option value="" selected>Aucun</option>
                                    <option v-for="categorie in categories" :key="categorie.id" :value="categorie.id">{{ categorie.name }}</option>
                                </select>
                            </div> 
                            <div  v-if="!$gate.isLocalStore()"  class="form-group">
                                <label class="form-label">Description</label>
                                <textarea v-model="form.description" class="form-control" type="text" name="description"
                                    placeholder="brève description de la categorie (facultatif)"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-danger rounded-pill px-4" data-bs-dismiss="modal"> Annuler </button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4" v-if="!editMode">Ajouter</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4" v-if="editMode"> Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import { assertExpressionStatement } from '@babel/types';

export default {
    data: () => ({
        store_id: null,
        categories:{}  , 
        currentCategorie: '',  
        form: new Form({
            id:'',
            name: '',
            description: '',
            slug:'',
            count:'',
            categorieParent: '',
            allCase: false,
        }),
        search : {
            name:'',
        },
        actionGrouper: '', // Variable pour stocker l'action sélectionnée
        boutonAppliquer: '', // Variable pour stocker l'action sélectionnée
        editMode: false,
        isLoading:true,
        selectedCategorieIds: [], // Ajout de la liste des IDs des categories sélectionnés
        //pagination
        pagination:{
            current_page:1,
            per_page:10,
            total_pages:0,
        },
        
    }),
    created(){
        if (this.$store.getters.currentBoutique)
            this.store_id = this.$store.getters.currentBoutique.id;

        this.loadCategories();
    },
    computed : {
        filteredCategories(){
            let filtered = Object.values(this.categories);
            if (this.search.name !== '') {
            filtered = filtered.filter(categorie =>
                categorie.name.toLowerCase().includes(this.search.name.toLowerCase())
            );
            }
            return filtered;
        },
            //pagination
            paginatedCategories(){
            this.pagination.total_pages = Math.ceil(this.filteredCategories.length / this.pagination.per_page);
            return this.filteredCategories.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
        },
    },
    methods:{
        //pagination
        changePage(page){
            this.pagination.current_page = page;
            },
        //
        sortByCreatedAt() {
        this.search.date_sort_order = this.search.date_sort_order === 'asc' ? 'desc' : 'asc';
        },
        
        loadCategories(){
            axios.get(`api/categorie/${this.store_id}`)
            .then((response) => {
            //   console.log(response.data);
                this.categories = response.data;
                console.log(this.categories);
                this.isLoading = false;
            })
            .catch(({response}) => console.log(response.data));
        },

        createCategorie(){
            const categorieData = {
                name: this.form.name,
                description: this.form.description,
                slug: this.form.slug,
                categorieParentId: this.form.categorieParent,
                store: this.store_id,
            };
            this.$Progress.start();
            axios.post('api/categorie', categorieData)
            .then((response) => {
                console.log(response.data);
                this.loadCategories();
                this.$Progress.finish();
                Swal.fire('Bon travail!', 'Categorie ajouté avec succès!', 'success');
                $('#AddnewModal').modal('hide');
            })
            .catch((error) => console.log(error));
        },
        updateCategorie(){
            const categorieData = {
                id: this.form.id,
                name: this.form.name,
                description: this.form.description,
                slug: this.form.slug,
                categorieParentId: this.form.categorieParent,
                store: this.store_id,
            };
            this.$Progress.start();
            axios.put(`api/categorie/${categorieData.id}`, categorieData)
            .then((response) => {
                console.log(response.data);
                this.loadCategories();
                this.$Progress.finish();
                Swal.fire(
                'Bon travail!',
                'Categorie mis à jour avec succès!',
                'success'
                );
                $('#AddnewModal').modal('hide');
            })
            .catch((error) => console.log(error));
        },
        deleteCategorie(id){
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
                axios.delete(`/api/categorie/${this.store_id}/${id}`)
                .then(() => {
                    this.loadCategories();
                    Swal.fire(
                    'Supprimé!',
                    'La categorie a été supprimé',
                    'success'
                    )
                })
                .catch(({response}) => {
                    console.log(response.data);
                });
                }
            })    
        },
        editModal(categorie){
            this.editMode = true;
            this.form.reset();
            this.form.fill(categorie);
            this.form.categorieParent= "";
            $('#AddnewModal').modal('show');
        },
        addModal(){
            this.editMode = false;
            this.form.reset();
            $('#AddnewModal').modal('show');
        },
        //Traitement des cases cocher
        selectAllCases() {
            if (this.form.allCase) {
                const start = (this.pagination.current_page - 1) * this.pagination.per_page;
                const end = start + this.pagination.per_page;
                this.selectedCategorieIds = this.filteredCategories.slice(start, end).map((categorie) => categorie.id);
            } else {
                this.selectedCategorieIds = [];
            }
            this.updateAllCaseStatus();
        },
        selectIndividualCase(categorieId) {
            const index = this.selectedCategorieIds.indexOf(categorieId);

            if (index === -1) {
                // Si la categorie n'est pas déjà sélectionné, l'ajouter à la liste
                this.selectedCategorieIds.push(categorieId);
            } else {
                // Si la categorie est déjà sélectionné, le retirer de la liste
                this.selectedCategorieIds.splice(index, 1);
            }
            this.updateAllCaseStatus();
        },
        updateAllCaseStatus() {
            this.form.allCase = this.filteredCategories.length === this.selectedCategorieIds.length;
            console.log('IDs des categories sélectionnés :', this.selectedCategorieIds);
            console.log('allcase:', this.form.allCase);
        },
        applyAction() {
            if (this.actionGrouper === 'supprimer') {
                if (this.selectedCategorieIds.length > 0) { 
                this.boutonAppliquer = 'supprimer';
                this.deleteSelectedCategories(); // Appeler la fonction deleteSelectedCategories
                } 
                else {
                Swal.fire(
                    'Aucune categorie sélectionné !',
                    'Veuillez choisir un ou plusieurs categories!',
                    'warning'
                    );
                }
            }
        },
        cancelUpdate() {
            this.actionGrouper = ""; // Réinitialiser l'action de recherche à vide pour afficher le tableau des produits
            this.selectedCategorieIds = []; // Vider la liste des produits sélectionnés
            this.form.allCase= '';
            this.boutonAppliquer=false;
        },
        // Méthode pour supprimer en masse les categories sélectionnés
        deleteSelectedCategories(){
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Vous ne pourrez pas revenir en arrière!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimez-les!',
                cancelButtonText: 'Annuler',
            }).then((result) => {
                if (result.isConfirmed) {
                this.$Progress.start();
                let vm = this;
                axios.delete('/api/categories/supprimerEnMasse',{ 
                    data: 
                    {
                        ids: this.selectedCategorieIds,
                        store: this.store_id
                    }
                    })
                .then((response) => {
                    this.loadCategories();
                    this.cancelUpdate();
                    Swal.fire(
                    'Supprimé!',
                    'Les categories ont été supprimé',
                    'success'
                    )
                })
                .catch((error) => console.log(error));
                }
            })
        },
    }

    
}
</script>
<style>
/* Modifier la taille de police pour les en-têtes */
.card-header h3.card-title {
    font-size: 22px; 
    color: #01356F;
    
}

/* Modifier la taille de police pour les boutons */
.btn {
    font-size: 14px; 
}

/* Modifier la taille de police pour les cellules de tableau */
.table td, .table th {
    font-size: 14px;
    color: #01356F;

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
.row.mt-3 .col input.form-control,
.row.mt-3 .col select.form-control {
    font-size: 13px; 
}
.spinner-container {
    position: fixed;
    top: 43%; /* Ajustez cette valeur pour centrer verticalement */
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
    background-color: rgba(255, 255, 255, 0.7); 
}
.inline-input {
    display: inline-block; /* ou 'inline-flex' selon vos préférences */
    max-width: 200px; /* Vous pouvez ajuster cette valeur selon vos besoins */
    }
</style>