<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card">
              <!-- <div class="card-header" style="position:static;"> -->
              <div class="card-header" style="background-color: #2f4fb1; display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
                <h3 class="card-title text-white">Produits</h3>
                <div class="card-tools">
                  <button class="btn btn-light" style="color: #01356F; " @click="showImportModal()">
                      Importer Produits(.xlsx)
                      <i class="fas fa-file-import fa-fw"></i>
                  </button>
                  <button @click="addProduct()" class="btn btn-light"  style="color: #01356F;">
                    Nouveau <i class="ti ti-plus"></i>
                  </button>
                  <!-- <button  v-if="!$gate.isLocalStore()" @click="addProductApi()" class="btn btn-light"  style="color: #01356F;">
                    Nouvel Api <i class="ti ti-plus"></i>
                  </button> -->
                </div>  
              </div>
              <div class="card-body table-responsive p-0">
                <!-- search bar as container and every input is a column -->
                <div class="row mt-2">
                  <div class="col ms-2 mt-2">
                    <input type="text" class="form-control" placeholder="Nom" v-model="search.name">
                  </div>
                  <!--div class="col-md-2 ms-5 mt-2">
                    <input type="text" class="form-control" placeholder="sku" v-model="search.sku">
                  </div>-->
                  <div class="col mt-2">
                    <select class="form-select search-select" v-model="search.stock_status">
                      <option value="" selected>Stock Status</option>
                      <option value="instock">En stock</option>
                      <option value="outofstock">Rupture de stock</option>
                      <option value="onbackorder">En reaprovisionnement</option>
                    </select>
                  </div>
                  <div class="col mt-2">
                    <select class="form-select search-select" v-model="search.pub_status">
                      <option value="" selected>Pub Status</option>
                      <option value="publish">Publier</option>
                      <option value="draft">Brouillon</option>
                      <option value="pending">En attente</option>
                    </select>
                  </div>
                  <div class="col mt-2">
                    <select class="form-select search-select" v-model="search.selectedCategory" @change="searchByCategories">
                      <option value="all" selected>Toutes les categories</option>
                      <option v-for="categorie in filteredCategories" :key="categorie.id" :value="categorie.name" >{{ categorie.name }}</option>
                    </select>
                    <div class="selected-categories">
                      <span class="badge badge-secondary me-2" v-for="(category, index) in search.categories" :key="index">
                        {{ category}}
                        <a @click="removeCategory(index)">
                          <i class="fas fa-times"></i>
                        </a>
                      </span>
                    </div>
                  </div>
                  <div class="col mt-2 me-2">
                    <select class="form-select search-select" v-model="search.brand">
                      <option value="" selected>Selectionner une marque</option>
                      <option v-for="brand in brands" :key="brand.id" :value="brand.name" >{{ brand.name }}</option>
                    </select>
                  </div>
                </div>
                <div v-if="boutonAppliquer === 'modifier'" class="row mt-3">
                  <!-- Partie gauche avec les produits sélectionnés -->
                  <div class="col-md-6">
                    <div class="selected-products">
                      <div class="scrollable-orders">
                        <div v-for="(productId, index) in selectedProductIds" :key="index">
                          <a @click="removeSelectedProduct(productId)">
                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                          </a>
                          {{ getProductName(productId) }}
                          <!-- <button @click="removeSelectedProduct(productId)">Supprimer</button> -->
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Partie droite avec la liste des catégories et des marques-->
                  <div class="col-md-6">
                    <div class="form-group" id="categorie-form">
                      <label for="categorie"  class="form-label">Catégories :</label>
                      <div>
                        <select class="form-select" v-model="form.selectedCategory" @change="selectCategory">
                          <option value="" selected>Selectionner une categorie</option>
                          <option v-for="categorie in unSelectedCategories" :key="categorie.id" :value="categorie.id" >{{ categorie.name }}</option>
                        </select>
                        <div class="selected-categories">
                          <span class="badge badge-info me-2" v-for="(category, index) in selectedCategories" :key="index">
                            {{ category}}
                            <a @click="unSelectCategory(index)">
                              <i class="fas fa-times"></i>
                            </a>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="brand" class="form-label">Marque :</label>
                      <select  class="form-select" v-model="form.brand">
                        <option value="" selected>Selectionner une marque</option>
                        <option v-for="brand in brands" :key="brand.id" :value="brand.name">{{ brand.name }}</option>
                      </select>
                  </div> 
                  </div>
                  <!-- Boutons Mettre à jour et Annuler -->
                  <div class="col-md-12 text-center mt-4">
                    <button @click="updateSelectedProducts" class="btn btn-primary rounded-pill px-4">Mettre à jour</button>
                    <button @click="cancelUpdate" class="btn btn-secondary rounded-pill px-4">Annuler</button>
                  </div>
                </div>
                <table v-else class="table table-hover text-nowrap">
                  <div class="spinner-container" v-if="$store.state.isLoading" style="top: 55%;transform: translate(-50%, -50%);">
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
                      <th>ID Produit</th>
                      <th>Nom</th>
                      <th>Reference</th>
                      <th>Statut Stock</th>
                      <th>
                          Prix
                          <a @click="sortByPrice()" style="cursor:pointer">
                            <i  class="fas fa-sort-up blue" v-if="this.search.prix === 'asc'"></i>
                            <i class="fas fa-sort-down blue" v-if="this.search.prix === 'desc'"></i>
                          </a>
                      </th>
                      <th>
                        Quantite Stock
                        <a @click="sortByStockQuantity()" style="cursor:pointer">
                          <i  class="fas fa-sort-up blue" v-if="this.search.quantite === 'asc'"></i>
                          <i class="fas fa-sort-down blue" v-if="this.search.quantite === 'desc'"></i>
                        </a>
                      </th>
                      <th>Categories</th>
                      <th>Marque</th>
                      <th>Action</th>
                  </thead>
                  <tbody>
                    <tr  v-if="!$store.state.isLoading" v-for="product in paginatedProducts" :key="product.id">
                      <td>
                        <!-- <input type="checkbox" v-model="product.case"> -->
                        <div class="n-chk align-self-center text-center">
                          <div class="form-check">
                            <input type="checkbox"
                              class="form-check-input contact-chkbox primary"
                              :id="'checkbox_' + product.id"
                              :value="product.id"
                              :checked="selectedProductIds.includes(product.id)"
                              @change="selectIndividualCase(product.id)"
                            />
                            <label class="form-check-label" :for="'checkbox_' + product.id"></label>
                          </div>
                        </div>
                      </td>
                      <td style="width:5%">{{ product.id }}</td>
                      <td style="max-wdith:20%;width: 20%;" >
                        <p style="max-width: 100% !important;white-space: pre-wrap" >{{ product.name}}</p> 
                        <span v-if="product.status === 'publish'" class="badge badge-success">{{ product.status }} </span>
                        <span v-if="product.status === 'draft'" class="badge badge-warning">{{ product.status }} </span>
                        <span v-if="product.status === 'pending'" class="badge badge-info">{{ product.status }} </span>
                      </td> 
                      <td style="width:5%">{{ product.sku }}</td>
                      <td style="width:10%">{{ product.stock_status }} </td>
                      <td style="width:5%">{{ product.price | prix }}  </td>
                      <td style="width:5%">{{ product.stock_quantity }} </td>
                      <td style="width: 40%;">
                            <div class="d-flex flex-wrap w-100" >
                              <span v-for="(categorie, categorieIndex) in product.categories" :key="categorieIndex" class="badge badge-secondary m-3">
                                {{ categorie.name }}
                              </span>
                            </div>
                      </td>
                      <td v-if="$gate.isLocalStore()" style="width: 20%;">
                        <div class="badge m-3" style="background-color: #f72d; color: black;list-style-type: none;">
                          {{ product.marques.name}}
                        </div>
                      </td>
                      <td v-else style="width: 20%;">
                        <div class="d-flex flex-wrap w-100" >
                          <ul v-for="(attribute, attributeIndex) in product.attributes" :key="attributeIndex" class="badge m-3" style="background-color: #f72d; color: black;list-style-type: none;">
                            <template v-if="attribute.name === 'Brands'">
                              <li v-for="(brand, brandIndex) in attribute.options" :key="brandIndex">
                                {{ brand }}
                              </li>
                            </template>
                          </ul>
                        </div>
                      </td>
                      <td style="width:10%">
                          <button @click="editProduct(product)" class="btn btn-info"><i class="ti ti-edit"></i></button>
                          <button @click="deleteProduct(product)" class="btn btn-danger"><i class="ti ti-trash-x"></i></button>
                      </td>
                    </tr>
                    <!-- <tr class="spinner-container" v-if="$store.state.isLoading">
                        <loader></loader>
                      </tr> -->
                  </tbody>
                </table>
                <div class="row mt-3">
                  <div class="col-md-6 mb-3 d-flex align-items-center">
                    <div class="d-flex justify-content-center">
                      <select class="form-select me-2" v-model="actionGrouper">
                        <option value="" selected>Actions groupées</option>
                        <option value="modifier">Modifier</option>
                        <option value="supprimer">Supprimer</option>
                      </select>
                      <button type="button" class="btn btn-outline-info m-1" @click="applyAction">Appliquer</button>
                    </div>
                  </div>
                  <div v-if="!$store.state.isLoading" class="col-md-6 d-flex justify-content-end">
                    <nav>
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
    </div>        
    <!-- Product Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-if="!editMode" class="modal-title" id="productModalLabel">Ajouter un produit</h5>
            <h5 v-if="editMode" class="modal-title" id="productModalLabel">Modifier un produit</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fermer">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="produit-form" @submit.prevent="editMode ? updateProduct() : createProduct()">
            <div class="modal-body">
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Nom:</label>
                <input type="text" class="form-control" id="name" v-model="form.name">
              </div>
              <div v-if="ProductValidationErrors.name" class="text-danger">
                <i class="fa fa-exclamation-triangle"></i> {{ ProductValidationErrors.name[0] }}
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Description:</label>
                <textarea v-model="form.description" class="form-control" type="text" name="description"
                  placeholder="brève description de l'utilisateur (facultatif)"></textarea>
              </div>
              <div class="form-group">
                <label for="price" class="col-sm-2 control-label">Prix:</label>
                <input type="number" id="price" class="form-control" v-model="form.price">
              </div>
              <div class="form-group">
                <label for="sku" class="col-sm-2 control-label">Reference:</label>
                <input type="text" class="form-control" id="sku" v-model="form.sku">
              </div>
              <div class="form-group">
                <label for="stock_status" class="col-sm-2 control-label">Status publication:</label>
                <select v-model="form.pub_status" class="select-form" >
                  <option value="" selected>Status</option>
                  <option value="publish">Publier</option>
                  <option value="draft">Brouillon</option>
                  <option value="pending">En attente</option>
                </select>
              </div>
              <div v-if="ProductValidationErrors.pub_status" class="text-danger">
                <i class="fa fa-exclamation-triangle"></i> {{ ProductValidationErrors.pub_status[0] }}
              </div>
              <div class="form-group">
                <label for="stock_status" class="col-sm-2 control-label">Status du stock:</label>
                <select disabled class="select-form" v-model="form.stock_status">
                  <option value="instock">En stock</option>
                  <option value="onbackorder">En attente</option>
                  <option value="outofstock">Rupture de stock</option>
                </select>
              </div>
              <div class="form-group">
                <label for="stock_quantity" class="col-sm-2 control-label">Quantite du stock:</label>
                <input type="number" class="form-control" id="stock_quantity" v-model="form.stock_quantity" disabled>
              </div>
              <div class="form-group">
                <label for="slug" class="col-sm-2 control-label">Permalien:</label>
                <input type="text" class="form-control" id="slug" v-model="form.slug">
              </div>
              <div class="form-group" id="brand-form">
                <label for="brand" class="col-sm-2 control-label">Marque :</label>
                <select class="form-control" id="brand" v-model="form.brand">
                  <option value="" selected>Selectionner une marque</option>
                  <option v-for="brand in brands" :key="brand.id" :value="brand.name">{{ brand.name }}</option>
                </select>
              </div> 
              <div class="form-group" id="categorie-form">
                <label for="categorie"  class="col-sm-2 control-label">Catégories :</label>
                <div>
                  <select class="form-control" v-model="form.selectedCategory" @change="selectCategory">
                    <option value="" selected>Selectionner une categorie</option>
                    <option v-for="categorie in unSelectedCategories" :key="categorie.id" :value="categorie.id" >{{ categorie.name }}</option>
                  </select>
                  <div class="selected-categories">
                    <span class="badge badge-info me-2" v-for="(category, index) in selectedCategories" :key="index">
                      {{ category}}
                      <a @click="unSelectCategory(index)">
                        <i class="fas fa-times"></i>
                      </a>
                    </span>
                  </div>
                </div>
              </div>
              <div v-if="ProductValidationErrors.categories" class="text-danger">
                <i class="fa fa-exclamation-triangle"></i> {{ ProductValidationErrors.categories[0] }}
              </div>
              <!--<div class="form-group">
                <label for="attribute" class="col-sm-2 control-label">Attribut :</label>
                <select class="form-select" id="attribute" v-model="selectedAttribute">
                  <option value="" selected disabled>Select an attribute</option>
                  <option v-for="attribute in attributes" :key="attribute.id" :value="attribute.id">{{ attribute.name }}</option>
                </select>
              </div>-->
            </div>  
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
              <button type="submit" class="btn btn-primary" v-if="!editMode">Ajouter</button>
              <button type="submit" class="btn btn-primary" v-if="editMode">Modifier</button>
            </div>
          </form>
        </div>
      </div>
    </div>

        <!-- Product Api Modal -->
        <div class="modal fade" id="productApiModal" tabindex="-1" role="dialog" aria-labelledby="productApiModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="productModalLabel">Ajouter un produit</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fermer">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="produit-form"  @submit.prevent="submitProductApi">
            <div class="modal-body">
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Nom</label>
                <input type="text" class="form-control" id="name" v-model="formApi.name">
              </div>
            </div>  
            <div class="modal-body">
              <div class="form-group">
                <label for="lien" class="col-sm-2 control-label">lien</label>
                <input type="text" class="form-control" id="lien" v-model="formApi.lien">
              </div>
            </div>  
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
              <button type="submit" class="btn btn-primary">Ajouter</button>
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
                  <h5 class="modal-title">Importer des produits sous format Excel</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" @click="cancelImport">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- File input -->
                    <!--<input type="file" :accept="['.xls', '.xlsx']" @change="importExcelFile" />-->
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" :accept="['.xls', '.xlsx']" @change="importExcelFile" />
                        <label class="custom-file-label">
                          <i class="fas fa-upload"></i> Télécharger le fichier
                        </label>
                      </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" @click="cancelImport">Annuler</button>
                    <button type="button" class="btn btn-primary" @click="submitImport">Envoyer</button>
                </div>
            </div>
        </div>
    </div>

  </div>
</template>
<script>
import axios from 'axios';
import { mapState, mapActions } from 'vuex';

export default {
  data(){
    return {
      // products: [],
      categories: [],
      brands: [],
      attributes: [],
      selectedAttribute: '',
      attributeTerms: [],
      store_id: null,
      formApi:{
        name:'',
        lien:'',
      },
      form:{
        id: '',
        name: '',
        description: '',
        price: '0',
        sku: '',
        stock_quantity: '0',
        stock_status: 'outofstock',
        pub_status:'',
        slug: '',
        categories: [],
        //brands: [],
        brand: '',
        selectedCategory: '',
        allCase: false,
      },
      search:{
        name: '',
        sku: '',
        stock_status: '',
        pub_status: '',
        prix:'asc',
        quantite:'asc',
        categories:[],
        brand:'',
        selectedCategory: 'all',
        selectedBrand: 'all',
        brands:[],
      },
      editMode: false,
      edit_category:{},
      category_name: '',
      CategoryValidationErrors: {},
      edit_brand:{},
      brand_name: '',
      BrandValidationErrors: {},
      ProductValidationErrors: {},
      //pagination
      pagination:{
        current_page:1,
        per_page:10,
        total_pages:0,
      },
      selectedProductIds: [], // Ajout de la liste des IDs des produits sélectionnés
      actionGrouper: '', // Variable pour stocker l'action sélectionnée
      boutonAppliquer: '', // Variable pour stocker l'action sélectionnée
    }
  },
  created(){
    // get store from current boutique
    // if(this.$store.getters.currentBoutique)
    //   this.store_id = this.$store.getters.currentBoutique.id;
    if (this.$store.getters.currentBoutique)
      this.store_id = this.$store.getters.currentBoutique.id;

    // Charger les produits et les catégories depuis le store Vuex
    // this.fetchProducts(this.store_id);
    // this.fetchCategories(this.store_id);

    // loadProducts
    this.loadProducts();
  },
  mounted(){
        //loads Categories
        this.loadProductCategories();
        this.loadProductBrands();
        this.fetchAttributes();
  },
  computed:{
    // ...mapState(['products', 'categories']),
    ...mapState(['products']),
    paginatedProducts(){
       this.pagination.total_pages = Math.ceil(this.filteredProducts.length / this.pagination.per_page);
        return this.filteredProducts.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
      },
    isEditing(){
      return this.edit_category.id !== undefined;
    },
    filteredProducts() {
      let filtered = Object.values(this.products);

      // Filtrer par nom
      if (this.search.name) {
        filtered = filtered.filter((product) => {
          return product.name.toLowerCase().includes(this.search.name.toLowerCase());
        });
      }

      // Filtrer par sku
      if (this.search.sku) {
        filtered = filtered.filter((product) => {
          return product.sku.toLowerCase().startsWith(this.search.sku.toLowerCase());
        });
      }

      // Filtrer par stock_status
      if (this.search.stock_status) {
        filtered = filtered.filter((product) => {
          return product.stock_status.toLowerCase().includes(this.search.stock_status.toLowerCase());
        });
      }

      // Filtrer par pub_status
      if (this.search.pub_status) {
        filtered = filtered.filter((product) => {
          return product.status.toLowerCase().startsWith(this.search.pub_status.toLowerCase());
        });
      }

      // Filtrer par prix
      if (this.search.prix) {
        if (this.search.prix === 'asc') {
          filtered = filtered.sort((a, b) => {
            return a.price - b.price;
          });
        } else {
          filtered = filtered.sort((a, b) => {
            return b.price - a.price;
          });
        }
      }

      // Filtrer par quantite
      if (this.search.quantite) {
        if (this.search.quantite === 'asc') {
          filtered = filtered.sort((a, b) => {
            return a.stock_quantity - b.stock_quantity;
          });
        } else {
          filtered = filtered.sort((a, b) => {
            return b.stock_quantity - a.stock_quantity;
          });
        }
      }

      // Filtrer par catégories
      if (this.search.categories.length > 0) {
        filtered = filtered.filter((product) => {
          return this.search.categories.every((category) => {
            return product.categories.some((productCategory) => {
              return productCategory.name.toLowerCase().includes(category.toLowerCase());
            });
          });
        });
      }
      // Filtrer par brand
      if (this.search.brand) {
        filtered = filtered.filter((product) => {
          const brandAttribute = product.attributes.find((attribute) => attribute.name === 'Brands');
          if (brandAttribute && brandAttribute.options) {
            return brandAttribute.options.some((option) => option.toLowerCase().includes(this.search.brand.toLowerCase()));
          }
          return false; // Si l'attribut 'Brands' n'existe pas ou n'a pas d'options, exclure le produit du filtrage
        });
      }
      return filtered;
     
    },   
    filteredCategories(){
      //categories that doesn't exist in the search.categories by name

      return this.categories.filter((category) => {
        return !this.search.categories.includes(category.name);
      });
    },
    unSelectedCategories(){
      return this.categories.filter((category) => {
        return !this.form.categories.includes(category.id);
      });
    },
    selectedCategories(){
      //I want array of categories name from this.form.categories that containt just id
      return this.form.categories.map((category) => {
        if(category !== undefined){
          let index = this.categories.findIndex((cat) => {
            return cat.id == category;
          });
          return this.categories[index].name;
        }
      });
    },
  },
  methods:{

    // ...mapActions(['fetchProducts', 'fetchCategories']),
    ...mapActions(['fetchProducts']),
    changePage(page){
            this.pagination.current_page = page;
        },
    removeCategory(index){
      this.search.categories.splice(index, 1);
      if(this.search.categories.length == 0)
        this.search.selectedCategory = 'all';
    },
    searchByCategories(){
      console.log(this.search.selectedCategory);
      if(this.search.selectedCategory !== undefined){
        if(this.search.selectedCategory == 'all'){
          this.search.categories = [];
          return;
        }  
        this.search.categories.push(this.search.selectedCategory);
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
        price: '0',
        sku: '',
        stock_quantity: '0',
        stock_status: 'outofstock',
        pub_status:'',
        slug: '',
        categories: [],
        
      }
    },
    fillForm(product){
      let description = product.description.replace(/<\/?[^>]+(>|$)/g, "");
      
      this.form = {
        id: product.id,
        name: product.name,
        description: description,
        price: product.price,
        sku: product.sku,
        stock_quantity: product.stock_quantity,
        stock_status: product.stock_status,
        pub_status: product.status,
        slug: product.slug,
        categories: product.categories.map((category) => category.id),
        brand: '',
      }
      // const attr = product.attributes.find((attribute) => attribute['name'] === "Brands");
      // if(attr !== undefined && attr !== null )
      //   this.form.brand = attr.options[0];
    },
    loadProducts() {
      const store_id = this.$store.getters.currentBoutique.id;
      // this.isLoading = true;
      this.fetchProducts(store_id)
        .then(() => {
          // this.products = this.$store.getters.products;
          console.log(this.products);
          // this.isLoading = false;
        })
        .catch(error => console.log(error));
    },
    loadProductCategories(){
      axios.get(`api/categorie/${this.store_id}`)
      .then((response) => {
        console.log(response.data);
        //insert response.data to categories in sorted order
        this.categories = [];
        response.data.forEach((category) => {
          category.editing = false;
          this.categories.push(category);
        });
        //sort by name
        this.categories.sort((a,b) => {
          return a.name.localeCompare(b.name);
        });
        console.log(response.data);
      })
      .catch((error) => console.log(error));
    },
    loadProductBrands(){
      axios.get(`api/brand/${this.store_id}`)
      .then((response) => {
        //insert response.data to categories in sorted order
        response.data.forEach((brand) => {
          brand.editing = false;
          this.brands.push(brand);
        });
        //sort by name
        this.brands.sort((a,b) => {
          return a.name.localeCompare(b.name);
        });
        console.log(response.data);
      })
      .catch((error) => console.log(error));
    },
    addProduct(){
      this.editMode = false;
      this.resetForm();
      this.ProductValidationErrors = {};
      $('#productModal').modal('show');
    },
    addProductApi(){
      this.resetForm();
      this.ProductValidationErrors = {};
      $('#productApiModal').modal('show');
    },
    editProduct(product){
      this.editMode = true;
      //console.log(product);
      this.ProductValidationErrors = {};
      this.fillForm(product);
      $('#productModal').modal('show');
    },
    fetchAttributes() {
    axios.get(`api/getAttributes/${this.store_id}`)
      .then((response) => {
        this.attributes = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
    }, 
    submitProductApi(){
      const productApi = {
        name: this.formApi.name,
        lien: this.formApi.lien,
        store: this.store_id,
      };

      this.$Progress.start();
      axios.post('api/productApi', productApi)
      .then((response)=>{
            console.log(response.data);
            this.loadProducts();
            Swal.fire('Bon travail!', 'Produit ajouté avec succès!', 'success');
            this.$Progress.finish();
            $('#productApiModal').modal('hide');
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
    createProduct() {
      // Vérifier s'il y a au moins une catégorie sélectionnée
      if(this.form.categories.length == 0){
        Swal.fire(
          'Error!',
          'Sélectionnez au moins une catégorie!',
          'error'
        );
        return;
      }
      //brand is required
      if(this.form.brand === ''){
        Swal.fire(
          'Error!',
          'Sélectionnez au moins une marque!',
          'error'
        );
        return;
      }
      // Définir le statut du stock sur "Rupture de stock" et la quantité sur 0
      this.form.stock_status = 'outofstock';
      this.form.stock_quantity = 0;

      const product = {
        name: this.form.name,
        description: this.form.description,
        price: this.form.price,
        sku: this.form.sku,
        stock_quantity: this.form.stock_quantity,
        stock_status: this.form.stock_status,
        pub_status: this.form.pub_status,
        slug: this.form.slug,
        categories: this.form.categories,
        // brandId: this.form.brandId, // Ajoutez l'ID de la marque sélectionnée
        brand:this.form.brand,
        store: this.store_id,
      };

      this.$Progress.start();
      axios.post('api/product', product)
        .then((response) => {
          console.log(response.data);
          this.loadProducts();
          this.$Progress.finish();
          this.ProductValidationErrors = {};
          Swal.fire('Bon travail!', 'Produit ajouté avec succès!', 'success');
          $('#productModal').modal('hide');
        })
        .catch((error) => {
          this.$Progress.fail();
          if (error.response.status === 422) {
            this.ProductValidationErrors = error.response.data.errors;
            console.log(this.ProductValidationErrors);
          }
        });
    },

    deleteProduct(product){
      Swal.fire({
        title: 'Êtes-vous sûr?',
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, supprimez-le!',
        cancelButtonText: 'Annuler',
      }).then((result) => {
        if (result.isConfirmed) {
          this.$Progress.start();
          let vm = this;
          axios.delete(`/api/product/${this.store_id}/${product.id}`)
          .then((response) => {
            console.log(response.data);
            vm.$Progress.finish();
            vm.loadProducts();
            Swal.fire(
              'Supprimé!',
              'Le produit a été supprimé.',
              'success'
            );
          })
          .catch((error) => console.log(error));
        }
      })
    },
    //Traitement des cases cocher
    selectAllCases() {
      if (this.form.allCase) {
        const start = (this.pagination.current_page - 1) * this.pagination.per_page;
        const end = start + this.pagination.per_page;
        this.selectedProductIds = this.filteredProducts.slice(start, end).map((product) => product.id);
      } else {
        this.selectedProductIds = [];
      }
      this.updateAllCaseStatus();
    },
    selectIndividualCase(productId) {
      const index = this.selectedProductIds.indexOf(productId);

      if (index === -1) {
        // Si le produit n'est pas déjà sélectionné, l'ajouter à la liste
        this.selectedProductIds.push(productId);
      } else {
        // Si le produit est déjà sélectionné, le retirer de la liste
        this.selectedProductIds.splice(index, 1);
      }
      this.updateAllCaseStatus();
    },
    updateAllCaseStatus() {
      this.form.allCase = this.filteredProducts.length === this.selectedProductIds.length;
      console.log('IDs des produits sélectionnés :', this.selectedProductIds);
      console.log('allcase:', this.form.allCase);
      },
    //Traitement de l'action grouper
    applyAction() {
      if (this.actionGrouper === 'modifier') {
        if (this.selectedProductIds.length > 0) { 
          this.boutonAppliquer = 'modifier';
          this.form.categories = [];
          this.form.brand = '';
        } 
        else {
          Swal.fire(
          'Aucun produit sélectionné !',
          'Veuillez choisir un ou plusieurs produits!',
          'warning'
          );
        }
      } else if (this.actionGrouper === 'supprimer') {
        if (this.selectedProductIds.length > 0) { 
          this.boutonAppliquer = 'supprimer';
          this.deleteSelectedProducts(); // Appeler la fonction deleteSelectedProducts
        } 
        else {
          Swal.fire(
            'Aucun produit sélectionné !',
            'Veuillez choisir un ou plusieurs produits!',
            'warning'
            );
        }
      }
    },
    getProductName(productId) {
      const product = this.products.find((product) => product.id === productId);
      return product ? product.name : ''; // Retourne le nom du produit ou une chaîne vide s'il n'est pas trouvé
    },
    // Méthode pour supprimer un produit sélectionné de la liste
    removeSelectedProduct(productId) {
      const index = this.selectedProductIds.indexOf(productId);
      if (index !== -1) {
        this.selectedProductIds.splice(index, 1);
      }
      console.log('IDs des produits sélectionnés :', this.selectedProductIds);
    },
    // Méthode pour mettre à jour les produits sélectionnés avec une nouvelle catégorie ou marque
    updateSelectedProducts() {
      //at least one category
      const products = {
        ids: this.selectedProductIds,
        categories: this.form.categories,
        marque: this.form.brand,
        store: this.store_id,
      }

      this.$Progress.start();
      axios.put('api/products/modificationEnMasse', products)
      .then((response) => {
        console.log(response.data);
        this.loadProducts();
        this.$Progress.finish();
        this.ProductValidationErrors = {};
        this.cancelUpdate();
        Swal.fire(
        'Bon travail!',
        'Produits mis à jour avec succès!',
        'success'
        );
        // Réinitialiser les données de modification groupée
      })
      .catch((error) => {
        this.$Progress.fail();
        if(error.response.status == 422){
          this.ProductValidationErrors = error.response.data.errors;
          console.log(this.ProductValidationErrors);
        }  
      });
    },
    // Méthode pour supprimer en masse les produits sélectionnés
    deleteSelectedProducts(){
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
          axios.delete('/api/products/supprimerEnMasse',{ 
              data: 
              {
                ids: this.selectedProductIds,
                store: this.store_id,
              }
             })
          .then((response) => {
            console.log(response.data);
            vm.$Progress.finish();
            vm.loadProducts();
            this.cancelUpdate();
            Swal.fire(
              'Supprimé!',
              'Les produits ont été supprimé.',
              'success'
            );
          })
          .catch((error) => console.log(error));
        }
      })
    },
    // Méthode pour annuler la modification groupée et restaurer la table des produits
    cancelUpdate() {
      this.actionGrouper = ""; // Réinitialiser l'action de recherche à vide pour afficher le tableau des produits
      this.selectedProductIds = []; // Vider la liste des produits sélectionnés
      this.form.categories = [];
      this.form.brand= '';
      this.form.allCase= '';
      this.boutonAppliquer=false;
    },

    updateProduct(){
      //at least one category
      if(this.form.categories.length == 0){
        Swal.fire(
          'Erreur!',
          'Sélectionnez au moins une catégorie!',
          'error'
        );
        return;
      }
      //brand is required
      if(this.form.brand === ''){
        Swal.fire(
          'Erreur!',
          'Sélectionnez au moins une marque!',
          'error'
        );
        return;
      }


      const product = {
        id: this.form.id,
        name: this.form.name,
        description: this.form.description,
        price: this.form.price,
        sku: this.form.sku,
        stock_quantity: this.form.stock_quantity,
        stock_status: this.form.stock_status,
        pub_status: this.form.pub_status,
        slug: this.form.slug,
        categories: this.form.categories,
        brand: this.form.brand,
        store: this.store_id,
      }

      this.$Progress.start();
      axios.put(`api/product/${product.id}`, product)
      .then((response) => {
        console.log(response.data);
        this.loadProducts();
        this.$Progress.finish();
        this.ProductValidationErrors = {};
        Swal.fire(
        'Bon travail!',
        'Produit mis à jour avec succès!',
        'success'
        );
        $('#productModal').modal('hide');
      })
      .catch((error) => {
        this.$Progress.fail();
        if(error.response.status == 422){
          this.ProductValidationErrors = error.response.data.errors;
          console.log(this.ProductValidationErrors);
        }  
      });
    },
    //excel import
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
        axios.post('api/product/import',formData)
        .then((response)=>{
            console.log(response.data);
            this.loadProducts();
            this.loadProductCategories();
        })
        .then(()=>{
            this.$Progress.finish();
            Swal.fire({
                icon: 'success',
                title: 'Products importés avec succès.'
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


#produit-form .form-group {
  display: grid;
  grid-template-columns: 1fr 2fr;
  grid-gap: 10px;
  margin-bottom: 10px;
}

#produit-form label {
  font-size: 14px;
  font-weight: bold;
  align-self: center;
}

#produit-form input, #produit-form select {
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

.selected-categories {
  display: flex;
  flex-wrap: nowrap;
  overflow-x: auto;
  margin-top: 10px;
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
  color: #ffff;
}

/* Modifier la taille de police pour les boutons */
.btn {
  font-size: 14px; 
}

.row.mt-2 .col input.form-control,
.row.mt-2 .col select.form-control {
  font-size: 13px; 
}
.selected-products {
  border: 1px solid #ccc;
  padding: 10px;
  margin-bottom: 20px;
  display: flex;
  flex-direction: column; /* Afficher les éléments en colonnes */
  overflow-y: auto; /* Ajouter une barre de défilement verticale */
  max-height: 400px; /* Définir une hauteur maximale pour activer la barre de défilement */
}

.selected-products div {
  margin-bottom: 10px;
}
.scrollable-orders {
  max-height: 400px; /* Hauteur maximale à partir de laquelle le défilement apparaîtra */
  overflow-y: auto; /* Ajout du défilement vertical si nécessaire */
}
</style>
