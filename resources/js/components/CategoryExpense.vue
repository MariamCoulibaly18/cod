<template>
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between">
            <div class="row">
                <div class="col-md-4 ms-3">
                      <input type="text" class="form-control" placeholder="Mot-clé" v-model="search.mot_cle">
                 </div>
                 <div class="col-md-4 col-md-6">
                                <select class="form-select" v-model="search.typeCategory">
                                    <option value="">Categorie type</option>
                                    <option v-for="typeCategory in parentCategorys" :key="typeCategory.id" :value="typeCategory.id">{{typeCategory.name}}</option>
                                </select>
                            </div>
            </div>
            <a class="btn h-50 w-10"  style="background-color: #ECECF1;color: #01356F;" @click="showDropdown" >
              Nouveau <i class="fa-solid fa-plus"></i>
            </a>

          </div>
        </div>
      </div>
      <div v-if="isDropdownVisible" class="provided">
         <a class="dropdown-item" @click="BusinessClick()" href="#"><i class="fa fa-briefcase" aria-hidden="true"></i> Catégorie d'entreprise</a>
         <a class="dropdown-item" @click="TeamClick()" href="#"><i class='fa fa-user'></i>Catégorie d'equipe</a>
        </div>
      <div class="row">
        <div  v-if="!isLoading" v-for="(category, index) in paginatedCategoryType" :key="category.id" class="col-lg-4 mt-3">
          <div class="card rounded-lg">
            <div class="card-body d-flex">
              <div class="mr-4">
                <div class="logo" :style="getLogoStyle(category)">
                  <h1 class="logo-text">{{ getLogoText(category) }}</h1>
                </div>
              </div>
              <div>
                <h1 class="align-middle" style="font-size: 15px;">{{ category.titre }}</h1>
                <div class="mt-2">
                  <p class="parent mb-0">{{ category.parent_category.name }}</p>
                </div>
              </div>
              <div class="ml-auto">
                <div>
                  <button
                    class="btn btn-secondary rounded-circle"
                    type="button"
                    id="dropdownMenuButton"
                    @click="toggleDropdown(index)"
                    style="background-color: white; color: black;"
                  >
                    <i class="fas fa-ellipsis-h"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="dropdown-menu" :class="{ 'show': activeDropdownIndex === index }">
                    <a class="dropdown-item" @click="editModal(category)" href="#"><i class="fas fa-edit fa-fw blue"></i>Modifier</a>
                    <a class="dropdown-item" @click="deleteCategory(category.id)" href="#"><i class="fa fa-trash red"></i>Supprimer</a>
          </div>
          <tr class="spinner-container" v-if="isLoading">
             <loader></loader>
          </tr>
        </div>
      </div>
       <!-- Add and Edit Modal -->
       <div class="modal fade" id="add_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editMode">Ajouter une categorie</h5>
                    <h5 class="modal-title" v-show="editMode">Modifier categorie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" @click="closeAddModal()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode ? updateCategorie() : createCategorie()">
                    <div class="modal-body">
                        <div class="container">   
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <div class="form-group">
                                        <label for="titre">titre</label>
                                        <input type="text" class="form-control" id="titre" placeholder="titre" v-model="form.titre">       
                                    </div>
                                    <div class="form-group">
                                        <label for="parent">Parent</label>
                                        <select v-model="form.parent_category_id" class="form-select" :class="{ 'is-invalid': form.errors.has('parent_category.id') }">
                                            <option value="">Parent </option>
                                            <option v-for="parent_category in parentCategorys" :key="parent_category.id" :value="parent_category.id">{{parent_category.name}}</option>
                                        </select>
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
  </template>
  
<script>
    export default {
        data() {
            return {
                parentCategorys:[],
                typeExpenses:[],
                categorys:[],
                editMode: false,
                form : new Form({
                    id: '',
                    titre: '',
                    parent_category_id: '',
                    type_depense_id: '',
                    parent_category:{
                        id:'',
                        name: '',
                    },
                    logo: '',
                }),
                activeDropdownIndex: null,
                logoColors: {}, //ligne pour stocker les couleurs des logos
                isDropdownVisible: false,
                selectedExpense: null,
                search:{
                    status: '',
                    typeCategory:'',
                    mot_cle:'',
                },
                //pagination
                pagination:{
                    current_page:1,
                    per_page:9,
                    total_pages:0,
                },
                isLoading:true,
            }
        },
        computed:{ 
            paginatedCategoryType(){
                this.pagination.total_pages = Math.ceil(this.filteredCategoryType.length / this.pagination.per_page);
                return this.filteredCategoryType.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
                },
            filteredCategoryType() {
                let filtered = Object.values(this.categorys);
                // Filtrer par catégories
                if (this.search.typeCategory !== '') {
                    filtered = filtered.filter(category =>
                    category.parent_category.id == this.search.typeCategory
                    );
                }
                if (this.search.mot_cle !== '') {
                    filtered = filtered.filter(category =>
                    category.parent_category.name.toLowerCase().includes(this.search.mot_cle.toLowerCase()) 
                    || category.titre.toLowerCase().includes(this.search.mot_cle.toLowerCase())
                    );
                }
  
                return filtered;
                },
        },
        mounted(){
            this.loadCategoryDepense();
            this.loadParentCategory();
        },
        methods:{
            //pagination
            changePage(page){
                this.pagination.current_page = page;
            },
            getLogoStyle(category) {
                let randomColor = this.logoColors[category.id]; // Utiliser la couleur stockée
                if (!randomColor) {
                    randomColor = this.getRandomColor();
                    this.logoColors[category.id] = randomColor; // Stocker la couleur
                }
                return `background-color: ${randomColor}`;
            },
            getLogoText(category) {
                const words = category.titre.split(" ");
                const initials = words.map((word) => word.charAt(0).toUpperCase());
                return initials.join("");
            },
            getRandomColor() {
                const letters = "0123456789ABCDEF";
                let color = "#";
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
            },
            toggleDropdown(index) {
                if (this.activeDropdownIndex === index) {
                    this.activeDropdownIndex = null;
                } else {
                    this.activeDropdownIndex = index;
                }
            },
            loadCategoryDepense() {
                axios
                    .get('api/categoryExpenses')
                    .then((response) => {
                        // La réponse de l'API est accessible via response.data
                        console.log(response.data.categorys);
                        this.categorys = response.data.categorys;
                        this.isLoading = false;

                    })
                    .catch((error) => console.log(error));
            },
            loadParentCategory() {
                axios
                    .post('api/parentCategory')
                    .then((response) => {
                        // La réponse de l'API est accessible via response.data
                        console.log(response.data.parentCategorys);
                        this.parentCategorys = response.data.parentCategorys;
                    })
                    .catch((error) => console.log(error));
            },
            showDropdown() {
            this.isDropdownVisible = !this.isDropdownVisible;
            // this.showAlert = true;
            },
            BusinessClick() {
                this.selectedExpense= 1;
                this.editMode = false;
                this.form.reset();
                this.isDropdownVisible = false;
                $('#add_modal').modal('show'); // Utiliser l'identifiant correct du modal d'ajout
            },
            TeamClick() {
                this.selectedExpense= 2;
                this.editMode = false;
                this.form.reset();
                this.isDropdownVisible = false;
                $('#add_modal').modal('show'); // Utiliser l'identifiant correct du modal d'ajout
            },
            editModal(category){
                this.editMode = true;
                this.activeDropdownIndex=null;
                this.form.reset();
                this.form.fill(category);
                $('#add_modal').modal('show'); 
            },
            createCategorie(){
                this.form.type_depense_id= this.selectedExpense;
                const CategoryData = {
                parent_category_id: this.form.parent_category_id,
                type_depense_id: this.form.type_depense_id,
                titre: this.form.titre,
                };
                this.$Progress.start();
                console.log(CategoryData);
                axios.post('/api/categoryExpenses', CategoryData)
                .then((response) => {
                console.log(response.data);
                this.loadCategoryDepense();
                this.$Progress.finish();
                Swal.fire(
                'Bon travail!',
                'Categorie ajoutée avec succès !',
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
            this.loadCategoryDepense();
            $('#add_modal').modal('hide');
            },
            updateCategorie(){
            this.form.put(`/api/categoryExpenses/${this.form.id}`)
                .then(() => {
                $('#add_modal').modal('hide');
                Swal.fire(
                    'Bon travail!',
                    'La catégorie a été mise à jour avec succès!',
                    'success'
                );
                this.loadCategoryDepense();
                })
                .catch(({response}) => {
                this.$toast.error(response.data.message);
                });
            },
            deleteCategory(id){
             Swal.fire({
             title: 'Êtes-vous sûr ?',
             text: "Vous ne pourrez pas revenir en arrière!",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3b3f5c',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Oui, supprimez-la!',
             cancelButtonText: 'Annuler',
             }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/categoryExpenses/${id}`)
                    .then(() => {
                    this.loadCategoryDepense();
                    Swal.fire(
                        'Supprimée!',
                        'La categorie a été supprimé.',
                        'success'
                    )
                    })
                    .catch(({response}) => {
                    console.log(response.data);
                    });
                }
                })
            },
        }

    }
</script>


<style scoped>
.card {
  border-radius: 0.5rem;
  font-size: 12px; /* Modifiez selon la taille de police souhaitée */
}

.logo {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 60px;
  width: 60px;
  background-color: #ccc;
  border-radius: 50%;
  
}

.logo-text {
  color: white;
  font-size: 1.5rem;
}

.parent {
  white-space: pre-wrap;
  text-align: left;
  margin-top: 0.5rem;
  margin-bottom: 0;
  font-size: 12px; /* Modifiez selon la taille de police souhaitée */
}

/* .container-fluid {
  display: flex;
  flex-wrap: wrap;
} */
.container-fluid {
  width: 100%;
  padding-right: 15px;
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;
  flex-wrap: wrap;
  font-size: 14px; /* Modifiez selon la taille de police souhaitée */

  /* display: flex;
  flex-wrap: wrap; /* Ajout de la propriété flex-wrap */
}
.dropdown-menu {
  right: auto;
  left: 100%;
  top: 56px;
  transform: translateX(-100%);
  position: absolute;
  z-index: 2; 
}

.dropdown-menu.show {
  opacity: 1;
  pointer-events: auto;
}

.dropdown-item {
  padding: 0.5rem 1rem;
  color: black;
  text-decoration: none;
  display: block;
  transition: background-color 0.3s;
  right:1;
}

.dropdown-item:hover {
  background-color: #f8f9fa;
}
.provided {
  position: absolute;
  top: 145px; /*  définir la distance par rapport au haut de la page */
  right: 0; /*définir l'emplacement horizontal */
  background-color: rgba(255, 255, 255, 0.985);
  border-radius: 5px;
  border-width: 1px;
  padding: 5px;
  z-index: 999;
}

/* Modifie la taille du texte spécifiquement pour les éléments du dropdown */
.dropdown-item {
  font-size: 14px; /* Modifiez selon la taille de police souhaitée */
}

/* Modifie la taille du texte spécifiquement pour les boutons de pagination */
.page-link {
  font-size: 14px; /* Modifiez selon la taille de police souhaitée */
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