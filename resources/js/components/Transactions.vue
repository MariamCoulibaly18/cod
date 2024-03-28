<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-white">Transactions</h3>
                        <div class="card-tools">
                            <button class="btn btn-light" @click="newModal" style="color: #01356F;">
                              Nouveau <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                      <div class="row mt-3 ">
                          <div class="col">
                              <select class="form-select search-select" v-model="search.produit_id">
                                <option value="">Selectionner un produit</option>
                                <option v-for="produit in filterProducts" :key="produit.id" :value="produit.id">{{ produit.name }}</option>
                              </select>
                          </div>
                          <div class="col">
                              <select class="form-select search-select" v-model="search.marque_id">
                                <option value="">Selectionner une marque</option>
                                <option v-for="marque in filterMarques" :key="marque.id" :value="marque.id">{{ marque.name }}</option>
                              </select>
                          </div>
                          <div class="col">
                              <select class="form-select search-select" v-model="search.fournisseur_id">
                                <option value="">Selectionner un fournisseur</option>
                                <option v-for="fournisseur in filterFournisseurs" :key="fournisseur.id" :value="fournisseur.id">{{ fournisseur.name }}</option>
                              </select>
                          </div>
                          <!-- isFactured-->
                          <div class="col">
                            <select class="form-select search-select" v-model="search.is_factured">
                              <option value="">Sélectionner la Facturation</option>
                              <option value="1">Facturée</option>
                              <option value="0">Non facturée</option>
                            </select>
                          </div>
                           <!-- date-->
                          <div class="col">
                            <select class="form-select search-select"  v-model="search.date_transaction">
                              <option value="">Sélectionner une date</option>
                              <option v-for="date in dateSortOrder" :key="date" :value="date">{{ date }}</option>
                            </select>
                          </div>
                      </div>
                        <table class="table table-hover text-nowrap">
                          <div class="spinner-container" v-if="isLoading">
                            <loader></loader>
                          </div>
                            <thead>
                                <th>ID</th>
                                <th>Produit</th>
                                <th>Marque</th>
                                <th>Fournisseur</th>
                                <th>Quantite</th>
                                <th>Prix unitaire</th>
                                <th>
                                  Total
                                  <a @click="sortByTotal()" style="cursor:pointer">
                                    <i  class="fas fa-sort-up blue" v-if="this.search.total === 'asc'"></i>
                                    <i class="fas fa-sort-down blue" v-if="this.search.total === 'desc'"></i>
                                  </a>
                                </th>
                                <th>Date de la transaction</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                <tr v-if="!isLoading" v-for="transaction in paginatedTransactions" :key="transaction.id">
                                    <td >{{ transaction.id }}</td>
                                    <td>{{ transaction.produit_name }}</td>
                                    <td>{{ transaction.marque.name  }}</td>
                                    <td>{{ transaction.fournisseur.name }}</td>
                                    <td>{{ transaction.quantite }}</td>
                                    <td>{{ transaction.prix | prix}}</td>
                                    <td>{{ transaction.total | prix}}</td>
                                    <td >{{ transaction.created_at | myDate }}</td>
                                    <td>
                                        <button class="btn btn-secondary" @click="enleverTransaction(transaction.id)" title="Supprimer la transaction">
                                            <!-- annuler icon -->
                                            <i class="fa-solid fa-rotate-right"></i>
                                        </button>
                                        <!-- if status is completed ,show the button of 'generate invoice'-->
                                        <button  class="btn btn-warning" v-if="transaction.isFactured === false" @click="generateInvoice(transaction)" title="Generer la facture">
                                          <i class="fa-solid fa-file-invoice-dollar"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- <tr class="spinner-container" v-if="isLoading">
                                  <loader></loader>
                                </tr> -->
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
        <!-- Add Modal -->
        <div class="modal fade" id="addtransaction" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" v-if="!editMode">Ajouter une transaction</h5>
                <h5 class="modal-title" v-else>Modifier une transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" @click="closeAddModal()">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <!-- Form for adding/editing transaction -->
                <form @submit.prevent="submitTransaction">
                  <div class="form-group">
                    <label for="store">Boutique:</label>
                    <a class="form-control">{{ boutique.name }}</a>
                  </div>
                  <div class="form-group">
                    <label for="product">Produit:</label>
                    <select class="form-select" v-model="form.produit_id" @change="updateSelectedProductName">
                      <option value="">Selectionner un produit</option>
                      <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }}</option>
                    </select>
                  </div>
                  <div class="form-group" v-if="form.produit_id">
                    <label for="brand">Marque:</label>
                    <a class="form-control">{{ selectedProductBrand }}</a>
                  </div>
                  <div class="form-group">
                    <label for="fournisseur">Fournisseur:</label>
                    <select class="form-select" v-model="form.fournisseur_id">
                      <option value="">Selectionner le fournisseur</option>
                      <option v-for="fournisseur in fournisseurs" :key="fournisseur.id" :value="fournisseur.id" >{{ fournisseur.name }}</option>
                    </select>
                  </div>
                  <div class="form-group">
                  <label for="quantite">Quantité:</label>
                  <input type="number" class="form-control" v-model="form.quantite" @input="calculateTotal">
                  </div>
                  <div class="form-group">
                    <label for="price">Prix:</label>
                    <input type="number" class="form-control" v-model="form.prix" @input="calculateTotal">
                  </div>
                  <div class="form-group">
                    <label for="total">Total:</label>
                    <input type="number" class="form-control" v-model="form.total">
                  </div>
                  <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger rounded-pill px-4" data-bs-dismiss="modal" @click="closeAddModal()">Annuler</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Ajouter</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Marques modals-->
        <div >
            <div class="modal fade" id="marques_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Marques</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" @click=closeShowMarques()>
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">   
                            <div class="row">
                                <div class="form-group">
                                    <ul>
                                        <li v-for="marque in marques" :key="marque.id">
                                            <span style="font-weight: bold;">Nom:</span>
                                            <span>{{ marque.name }}</span>
                                            <span style="margin-left: 10px; font-weight: bold;">Quantité:</span>
                                            <span>{{ marque.quantite }}</span>
                                        </li> 

                                    </ul>
                                </div>
                            </div>                             
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger rounded-pill px-4" data-dismiss="modal" @click="closeShowMarques()">Fermer</button>
                    </div>
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
        products: [],
          transactions: [],
          boutiques: [],
          boutique: '',
          fournisseurs:[],
          brands:[],
          marques:[],
          fournisseurMarques:[],
          editMode: false,
          store_id: null,
          selectedProductBrand: '',
          visible:'',
          errors: [],
          marqueAjoute: 0,
          quantite: '',
          selectedMarqueId: null, // ID de la marque sélectionnée
          types:[],
          form: new Form({
              id:'',
              produit_id: '',
              fournisseur_id: '',
              quantite: '',
              marque_id: '',
              brand_id: null,
              prix:[],
              fournisseur:{
                  id:'',
                  name:'',
              },
              boutique:{
                  id:'',
                  name:'',
              },
              marque:{
                  id:'',
                  name:'',
              },
          }),
          dateSortOrder:['Les 7 derniers jours','Les 30 derniers jours','Les 3 derniers mois','Les 6 derniers mois','Les 12 derniers mois'],
          search:{
              produit_id:'',
              marque_id:'',
              fournisseur_id:'',
              date_transaction:'',
              total:'asc',
              is_factured:'',
          },
          filterProducts: [],
          filterMarques: [],
          filterFournisseurs: [],
          isLoading:true,
          //pagination
          pagination:{
              current_page:1,
              per_page:5,
              total_pages:0,
          },
          selectedProductName: '', 
      }
  },
  created(){
    // get store from current boutique
    if(this.$store.getters.currentBoutique)
      this.store_id = this.$store.getters.currentBoutique.id;
    // loadProducts
    this.loadtransactions();
    //this.loadFournisseurs();
    // this.loadbrands();
  },
  watch: {
    'form.produit_id': function(newValue) {
      if (newValue) {
        this.loadbrands();
      }
    }
  },
  computed:{
    //pagination
    paginatedTransactions(){
      this.pagination.total_pages = Math.ceil(this.filteredTransactions.length / this.pagination.per_page);
      return this.filteredTransactions.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
    },
    //
    filteredTransactions(){
      let filtered = Object.assign([], this.transactions);
      // filter by produit
      if(this.search.produit_id){
          filtered = filtered.filter((item) => {
              return item.produit_id == this.search.produit_id;
          });
      }

      // filter by marque
      if(this.search.marque_id){
          filtered = filtered.filter((item) => {
              return item.marque.id == this.search.marque_id;
          });
      }

      // filter by fournisseur
      if(this.search.fournisseur_id){
          filtered = filtered.filter((item) => {
              return item.fournisseur.id == this.search.fournisseur_id;
          });
      }

      // filter by date
      if(this.search.date_transaction){
          let date = new Date();
          switch (this.search.date_transaction) {
            case 'Les 7 derniers jours':
              date.setDate(date.getDate() - 7);
              break;
            case 'Les 30 derniers jours':
              date.setDate(date.getDate() - 30);
              break;
            case 'Les 3 derniers mois':
              date.setMonth(date.getMonth() - 3);
              break;
            case 'Les 6 derniers mois':
              date.setMonth(date.getMonth() - 6);
              break;
            case 'Les 12 derniers mois':
              date.setMonth(date.getMonth() - 12);
              break;
          }
          filtered = filtered.filter((item) => {
            return new Date(item.created_at) >= date;
          });
      }

      // sort by total
      if(this.search.total){
          filtered = filtered.sort((a, b) => {
              if(this.search.total === 'asc'){
                  return a.total - b.total;
              }else{
                  return b.total - a.total;
              }
          });
      }

      // filter by is_factured
      if(this.search.is_factured){
          filtered = filtered.filter((item) => {
              return item.isFactured === (this.search.is_factured === '1' ? true : false)
          });
      }
      return filtered;
    }

  },  
  methods:{
      //pagination
      changePage(page){
        this.pagination.current_page = page;
      },
      //sort by total
      sortByTotal(){
          this.search.total = this.search.total === 'asc' ? 'desc' : 'asc';
      },
      //
      loadtransactions(){
          axios.get(`api/transaction/${this.store_id}`)
          .then(({data}) => {
            this.transactions = data.transaction;
            console.log(this.transactions.length);
            //filters
            let vm = this;
            this.transactions.forEach((transaction) => {
              //Insertion des produits dans le filtre
              let index = vm.filterProducts.findIndex((item) => {
                return item.id == transaction.produit_id;
              });
              if(index === -1)
                vm.filterProducts.push({id: transaction.produit_id, name: transaction.produit_name});
              
                //Insertion des marques dans le filtre
                index = vm.filterMarques.findIndex((item) => {
                  return item.id == transaction.marque_id;
                });
                if(index === -1)
                  vm.filterMarques.push({id: transaction.marque.id, name: transaction.marque.name});
                  
                //Insertion des fournisseurs dans le filtre
                index = vm.filterFournisseurs.findIndex((item) => {
                  return item.id == transaction.fournisseur_id;
                });
                if(index === -1)
                  vm.filterFournisseurs.push({id: transaction.fournisseur.id, name: transaction.fournisseur.name});
            });
            this.boutique = data.boutique;
            this.isLoading = false;
            // Filtrer les transactions où visible est égal à 1
            this.transactions = this.transactions.filter(transaction => transaction.visible === 1);
          })
          .catch(({response}) => console.log(response.data));
      },
      loadProducts(){
        axios.get(`api/product/${this.store_id}`)
        .then((response) => {
          this.products = response.data;
          console.log(response.data);
        })
        .catch((error) => console.log(error));
      },

      loadbrands() {
        axios.post('/api/transactionBrand', {
          store: this.store_id,
          produit_id: this.form.produit_id
      })
      .then(response => {
          this.selectedProductBrand = response.data;
          this.loadFournisseursByBrand();

      })
      .catch(error => {
          console.log(error);
      });

    },
    loadFournisseursByBrand() {
      axios.get('/api/fournisseur')
        .then(({ data }) => {
          const fournisseurs = data.data;
          this.fournisseurs = fournisseurs.filter(fournisseur => {
            // Vérifier si la marque correspond
             const marqueMatch = fournisseur.marques.some(marques => {
                    if (marques.name === this.selectedProductBrand) {
                      this.marque_id = marques.id; // Assigner l'ID de la marque
                      console.log(this.marque_id);
                      return true; // Garder le fournisseur dans la liste filtrée
                    }
                    return false;
                  });
                  const typeMatch = fournisseur.type_id === 1;
                  return marqueMatch && typeMatch;
                });
        })
        .catch(({ response }) => {
          console.log(response.data);
        });
    },
    calculateTotal() {
      const quantite = this.form.quantite;
      const prix = this.form.prix;
      this.form.total = quantite * prix;
    },
    newModal() {
    // Réinitialiser les champs du formulaire
    this.form.reset();
    // Ouvrir le modal
    this.loadProducts();
    $("#addtransaction").modal("show");
  },
  updateSelectedProductName() {
    const selectedProduct = this.products.find(product => product.id === this.form.produit_id);
    this.selectedProductName = selectedProduct ? selectedProduct.name : '';
  },
  submitTransaction() {
    // Créez un objet contenant les données de la transaction à envoyer
    const transactionData = {
      boutique_id: this.boutique.id,
      produit_id: this.form.produit_id,
      produit_name: this.selectedProductName,
      fournisseur_id: this.form.fournisseur_id,
      marque_id: this.marque_id,
      quantite: this.form.quantite,
      prix: this.form.prix,
      total: this.form.total
    };
    console.log(transactionData);
    const product = {
      store: this.store_id,
      produit_id: this.form.produit_id,
      quantite: this.form.quantite,
    }
    this.$Progress.start();
    axios.post('/api/transaction', transactionData)
    .then((response) => {
      console.log(response.data);
      this.loadtransactions();
      this.$Progress.finish();
      axios.post(`api/transactionQuantite`, product)
      .then((response) => {
        console.log(response.data);
        this.loadProducts();})
      Swal.fire(
      'Bon travail!',
      "La transaction a été ajouté avec succès!",
      'success'
      );
      $('#addtransaction').modal('hide');
    })
    .catch((error) =>{
      this.$Progress.fail();
      console.log(error);
    });
  },


  closeAddModal(){
      $('#addtransaction').modal('hide');
  },
  enleverTransaction(id){
    this.visible=0;
    const data = {
      visible: this.visible,
    };
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
            axios.put(`/api/transaction/${id}`, data)
            .then(() => {
            this.loadtransactions();
            Swal.fire(
              'Supprimé!',
              'La transaction a été supprimée.',
              'success'
            )
            })
            .catch(({response}) => {
            console.log(response.data);
            });
        }
      })
  },
  generateInvoice(transaction){
    console.log(transaction.fournisseur.type_id);
    const data = {
      /*fournisseur:transaction.fournisseur.name,
      email:transaction.fournisseur.name+'@gmail.com',
      telephone:transaction.fournisseur.telephone,
      adresse:transaction.fournisseur.adresse,
      fr_type:transaction.fournisseur.type_id,
      ville:'Casablanca', // à changer par la suite
      pays:'Maroc', // à changer par la suite
      //transaction
      total:transaction.total,
      line_items:[{name:transaction.produit_name,quantity:transaction.quantite,price:transaction.prix,total:transaction.total}],
      //marque
      marque_name:transaction.marque.name,
      marque_logo:transaction.marque.logo,*/
      //
      store:this.store_id,
      transaction_id:transaction.id,
      //type:'tr',
    }
    axios.post(`api/facture/transaction`,data)
      .then((response) => {
        console.log(response.data);
        //swal success
        Swal.fire({
          icon: 'success',
          title: 'Invoice generated successfully',
          showConfirmButton: false,
          timer: 1500
        })
        //
        transaction.isFactured = true;
      })
      .catch((error) => {
        console.log('fetch error',error)
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong!',
        });
        
      });

  }
}
}
</script>
<style>
.icon-space {
    margin-left: 10px; /* Ajustez la valeur selon vos besoins */
}
.spinner-container {
    position: fixed;
    top: 43%; /* Ajustez cette valeur pour centrer verticalement */
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999; /* Assurez-vous que le spinner est au-dessus de tout le reste */
    background-color: rgba(255, 255, 255, 0.7); /* Un arrière-plan semi-transparent pour le contraste */
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

.search-select{
  font-size: 13px; 
}
.row.mt-3 .col input.form-control,
.row.mt-3 .col select.form-control {
  font-size: 13px; 
}
</style>