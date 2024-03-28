<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title text-white">Marques</h3>
            <div class="card-tools">
              <!-- button pour ajouter new brand-->
              <button @click="addbrand()" class="btn btn-light"  style="color: #01356F;"  >
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
                <th>Description</th>
                <th  v-if="!$gate.isLocalStore()" >Slug</th>
                <th  v-if="!$gate.isLocalStore()" >Total Produit</th>
                <th>Actions</th>
              </thead>
              <tbody>
                <tr v-if="!isLoading" v-for="brand in paginatedBrands" :key="brand.id">
                  <td>
                    <div class="n-chk align-self-center text-center">
                    <div class="form-check">
                        <input type="checkbox"
                        class="form-check-input contact-chkbox primary"
                        :id="'checkbox_' + brand.id"
                        :value="brand.id"
                        :checked="selectedBrandIds.includes(brand.id)"
                        @change="selectIndividualCase(brand.id)"
                        />
                        <label class="form-check-label" :for="'checkbox_' + brand.id"></label>
                    </div>
                    </div>
                  </td>
                  <td>{{ brand.name |  upText  }}</td>
                  <td>{{ brand.description ? brand.description : '—' }}</td>
                  <td  v-if="!$gate.isLocalStore()" >{{ brand.slug }}</td>
                  <td  v-if="!$gate.isLocalStore()" >{{ brand.count }}</td>
                  <td>
                  <button class="btn btn-info btn" @click="editModal(brand)">
                    <i class="fa-solid fa-edit fa-fw"></i>
                  </button>
                  <button class="btn btn-danger btn" @click="deletebrand(brand)">
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
          <!-- <div v-if="!isLoading" class="card-footer d-flex justify-content-center">
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
          </div>          -->
        </div>
      </div>
    </div>        
    <!-- Modal -->
    <div class="modal fade" id="AddnewModal" tabindex="-1" aria-labelledby="AddnewModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="AddnewModalLabel" v-if="!editMode">Ajouter une nouvelle marque</h5>
            <h5 class="modal-title" id="AddnewModalLabel" v-if="editMode">Modifier la marque</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form @submit.prevent="editMode ? updatebrand() : createbrand()">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nom</label>
                    <input v-model="form.name" type="text" name="name" placeholder="Nom" class="form-control" >
                </div>
                <div  v-if="!$gate.isLocalStore()"  class="form-group">
                    <label class="form-label">Slug</label>
                    <input v-model="form.slug" type="text" name="slug" placeholder="slug" class="form-control" >
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea v-model="form.description" class="form-control" type="text" name="description"
                        placeholder="brève description de la marque (facultatif)"></textarea>
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
  import axios from 'axios';
  
  export default {
    data(){
      return {
        brands: [],
        marques: [],
        currentMarque: '',  
        store_id: null,
        brandToModify: '',
        form: new Form({
            id:'',
            name: '',
            description: '',
            slug:'',
            count:'',
            allCase: false,
        }),
        search:{
          name: '',
        },
        actionGrouper: '', // Variable pour stocker l'action sélectionnée
        boutonAppliquer: '', // Variable pour stocker l'action sélectionnée
        selectedBrandIds: [], // Ajout de la liste des IDs des marques sélectionnés
        editMode: false,
        edit_category:{},
        category_name: '',
        //pagination
        pagination:{
          current_page:1,
          per_page:10,
          total_pages:0,
        },
        isLoading:true,
      }
    },
    created(){
      if(this.$route.query.store)
        this.store_id = this.$route.query.store;
       // get store from current boutique
       if(this.$store.getters.currentBoutique)
                this.store_id = this.$store.getters.currentBoutique.id;
            
      this.loadbrands();
  
    },
    computed:{
      paginatedBrands(){
        this.pagination.total_pages = Math.ceil(this.filteredbrands.length / this.pagination.per_page);
        return this.filteredbrands.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
       },
      filteredbrands(){
        let filtered = Object.assign([], this.brands);
        // Filter by name
          if (this.search.name !== '') {
            filtered = filtered.filter(brand =>
            brand.name.toLowerCase().includes(this.search.name.toLowerCase())
            );
          }  
        return filtered;
      }
    },
    methods:{
       //pagination
       changePage(page){
         this.pagination.current_page = page;
        },
      sortByPrice(){
        this.search.prix = this.search.prix == 'asc' ? 'desc' : 'asc';
      },
      sortByStockQuantity(){
        this.search.quantite = this.search.quantite == 'asc' ? 'desc' : 'asc';
      },
      resetForm(){
        this.form = {
          id: '',
          name: '',
          description: '',
        }
      },
      // fillForm(brand){
      //   let description = brand.description.replace(/<\/?[^>]+(>|$)/g, "");
      //   this.form = {
      //     id: brand.id,
      //     name: brand.name,
      //     description: description,
      //   }
  
      //   console.log(this.form);
      // },
      loadbrands(){
        axios.get(`api/brand/${this.store_id}`)
        .then((response) => {
          this.brands = response.data;
          this.isLoading = false;
          console.log(response.data);
         
        })
        .catch((error) => console.log(error));
      },
     
      addbrand(){
        this.editMode = false;
        this.resetForm();
        $('#AddnewModal').modal('show');
      },
      editModal(brand){
        this.editMode = true;
        // this.brandToModify = Object.assign({}, brand);
        // console.log(brand);
        this.form.reset();
        this.form.fill(brand);
        $('#AddnewModal').modal('show');
      },
      createbrand(){
        const brand = {
          name: this.form.name,
          description: this.form.description,
          store: this.store_id,
          slug: this.form.slug,
        }
  
        this.$Progress.start();
        axios.post(`api/brand`, brand)
        .then((response) => {
          console.log(response.data);
          this.loadbrands();
          this.$Progress.finish();
          Swal.fire(
          'Bon travail!',
          'Marque ajoutée avec succès !',
          'success'
          );
          $('#AddnewModal').modal('hide');
        })
        .catch((error) => console.log(error));
      },
      annulerAjout(){
        this.form.name = '';
        this.form.description = '';
        $('#AddnewModal').modal('hide');
      },
      deletebrand(brand){
        
        Swal.fire({
          title: 'Are you sure?',
          title: 'Êtes-vous sûr?',
          text: "Vous ne pourrez pas revenir en arrière!",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Oui, supprimez-la!',
          cancelButtonText: 'Annuler',
        }).then((result) => {
          if (result.isConfirmed) {
            this.$Progress.start();
            let vm = this;
            axios.delete(`/api/brand/${this.store_id}/${brand.id}`)
            .then((response) => {
              console.log(response.data);
              vm.$Progress.finish();
              const index = this.brands.indexOf(brand);
              vm.brands.splice(index, 1);
              Swal.fire(
              'Marque supprimée avec succès!',
              'success'
              );
            })
            .catch(({ response }) => {
              if (response.status === 422) {
                  Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: response.data.message,
                  });
              } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: "Une erreur s'est produite lors de la suppression de la marque.",
                  });
              }
          });
          }
        })
      },
      
   
      updatebrand(){
        const brand = {
          id: this.form.id,
          name: this.form.name,
          description: this.form.description,
          store: this.store_id,
        }
  
        this.$Progress.start();
        axios.put(`api/brand/${brand.id}`, brand)
        .then((response) => {
          console.log(response.data);
          this.loadbrands();
          this.$Progress.finish();
          Swal.fire(
          'Bon travail!',
          'La marque a été mise à jour avec succès!',
          'success'
          );
          $('#AddnewModal').modal('hide');
        })
        .catch((error) => console.log(error));
      },
      //Traitement des cases cocher
      selectAllCases() {
        if (this.form.allCase) {
            const start = (this.pagination.current_page - 1) * this.pagination.per_page;
            const end = start + this.pagination.per_page;
            this.selectedBrandIds = this.filteredbrands.slice(start, end).map((brand) => brand.id);
        } else {
            this.selectedBrandIds = [];
        }
        this.updateAllCaseStatus();
      },
      selectIndividualCase(brandId) {
        const index = this.selectedBrandIds.indexOf(brandId);

        if (index === -1) {
            // Si la marque n'est pas déjà sélectionné, l'ajouter à la liste
            this.selectedBrandIds.push(brandId);
        } else {
            // Si la marque est déjà sélectionné, le retirer de la liste
            this.selectedBrandIds.splice(index, 1);
        }
        this.updateAllCaseStatus();
      },
      updateAllCaseStatus() {
        this.form.allCase = this.filteredbrands.length === this.selectedBrandIds.length;
        console.log('IDs des marques sélectionnés :', this.selectedBrandIds);
        console.log('allcase:', this.form.allCase);
      },
      applyAction() {
        if (this.actionGrouper === 'supprimer') {
            if (this.selectedBrandIds.length > 0) { 
            this.boutonAppliquer = 'supprimer';
            this.deleteSelectedMarques(); // Appeler la fonction deleteSelectedMarques
            } 
            else {
            Swal.fire(
                'Aucune marque sélectionné !',
                'Veuillez choisir un ou plusieurs marques!',
                'warning'
                );
            }
        }
      },
      cancelUpdate() {
        this.actionGrouper = ""; // Réinitialiser l'action de recherche à vide pour afficher le tableau des produits
        this.selectedBrandIds = []; // Vider la liste des produits sélectionnés
        this.form.allCase= '';
        this.boutonAppliquer=false;
      },
      // Méthode pour supprimer en masse les marques sélectionnés
      deleteSelectedMarques(){
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
            axios.delete('/api/brands/supprimerEnMasse',{ 
                data: 
                {
                    ids: this.selectedBrandIds,
                    store: this.store_id
                }
                })
            .then((response) => {
                this.loadbrands();
                this.cancelUpdate();
                Swal.fire(
                'Supprimé!',
                'Les marques ont été supprimé',
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
  
  .form-horizontal .control-label{
  text-align: left;
  }
  .list-group{
  margin-top: 30px;
  }
  table{
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin: 0 auto;
  margin-top: 20px;
  text-align: center;
  font-size: 1rem;
  overflow-x: auto;
  /* white-space: nowrap; */
  }
  div{
  overflow-x: auto;
  white-space: nowrap;
  }
  th, td {
  border: 1px solid #ddd;
  padding: 10px;
  }
  th {
  background-color: #f2f2f2;
  font-weight: bold;
  }
  
  #marque-form .form-group {
    display: grid;
    grid-template-columns: 1fr 2fr;
    grid-gap: 10px;
    margin-bottom: 10px;
  }
  
  #marque-form label {
    font-size: 14px;
    font-weight: bold;
    align-self: center;
  }
  
  #marque-form input, #marque-form select {
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 14px;
  }
  
  
  button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    font-size: 16px;
    cursor: pointer;
  }
  
  button[type="submit"]:hover {
    background-color: #0069d9;
  }
  .list-scrollable {
    max-height: 200px;
    overflow-y: auto;
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
  