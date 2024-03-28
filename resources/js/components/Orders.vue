<template>
  <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-12">
              <div class="card">
                  <div class="card-header">
                      <h3 class="card-title text-white">Commandes</h3>                        
                      <!-- Button pour modification en masse-->
                      <div class="card-tools">
                        <button class="btn btn-light" @click="exportOrders()"  style="color: #01356F;">
                            Exporter commandes
                            <!-- icon pour export-->
                            <i class="fas fa-download fa-fw"></i>
                          </button>
                          <!-- Add order button-->
                          <button v-if="$gate.isLocalStore()" class="btn btn-light" @click="addNewOrder()"  style="color: #01356F;">
                            Nouveau <i class="fa-solid fa-plus"></i>
                          </button>
                      </div>
                  </div>
                  <div class="card-body table-responsive">
                    <div class="row mt-3">
                      <div class="col-8 mt-2 justify-content-center col-md-3">
                        <input type="text" class="form-control" style="font-size: 13px; " placeholder="Nom du client" v-model="search.client">
                      </div>
                      <!-- country-->
                      <div class="col-8 mt-2 col-md-3">
                        <select class="form-select search-select"  v-model="search.country">
                          <option value="">Sélectionner un pays</option>
                          <option v-for="country in countries" :key="country" :value="country">{{ country }}</option>
                        </select>
                      </div>
                      <!-- status-->
                      <div class="col-8 mt-2 col-md-3 ">
                        <select class="form-select search-select"  v-model="search.status">
                          <option value="">Sélectionner un status</option>
                          <option v-for="status in statusList" :key="status" :value="status">{{ status }}</option>
                        </select>
                      </div>
                      <!-- date-->
                      <div class="col-8 mt-2 col-md-3">
                        <select class="form-select search-select"  v-model="search.date">
                          <option value="">Sélectionner une date</option>
                          <option v-for="date in dateSortOrder" :key="date" :value="date">{{ date }}</option>
                        </select>
                      </div>
                    </div>
                    <div v-if="boutonAppliquer === 'modifier'" class="row mt-3">
                      <!-- Partie gauche avec les produits sélectionnés -->
                      <div class="col-md-6">
                        <div class="selected-orders">
                          <div class="scrollable-orders">
                            <div v-for="(orderId, index) in selectedOrderIds" :key="index">
                            <a @click="removeSelectedOrder(orderId)">
                              <i class="fa fa-times-circle" aria-hidden="true"></i>
                            </a>
                              {{ getOrder(orderId) }}
                              <!-- <button @click="removeSelectedOrder(orderId)">Supprimer</button> -->
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Partie droite avec la liste des catégories et des marques-->
                      <div class="col-md-6">
                        <div class="form-group" id="categorie-form">
                          <label for="status"  class="form-label">Status</label>
                          <div>
                            <select class="form-select" v-model="status">
                              <option value="">Sélectionner un statut</option>
                              <option v-for="status in statusList" :key="status" :value="status">{{ status }}</option>
                            </select>
                            <span class="text-danger" v-if="status === ''">Veuillez sélectionner un statut</span>
                          </div>
                        </div>
                      </div>
                      <!-- Boutons Mettre à jour et Annuler -->
                      <div class="col-md-12 text-center mt-4">
                        <!-- <button type="button" class="btn btn-primary" @click="updateOrdersStatus()" :disabled="status === ''">Enregistrer</button> -->
                        <button @click="updateSelectedOrders" :disabled="status === ''" class="btn btn-primary rounded-pill px-4">Mettre à jour</button>
                        <button @click="cancelUpdate" class="btn btn-secondary rounded-pill px-4">Annuler</button>
                      </div>
                    </div>
                    <table v-else class="table table-hover text-nowrap">
                      <div class="spinner-container" v-if="isLoading" style="top: 55%;transform: translate(-50%, -50%);">
                        <loader></loader>
                      </div>
                      <thead>
                          <th>   
                            <!-- <input type="checkbox" v-model="allCase"> -->
                            <div class="n-chk align-self-center text-center">
                              <div class="form-check" >
                                <input  type="checkbox"
                                  class="form-check-input primary"
                                  id="contact-check-all"
                                  v-model="allCase"
                                  @change="selectAllCases"
                                />
                                <label class="form-check-label" for="contact-check-all"></label>
                                <span class="new-control-indicator"></span>
                              </div>
                            </div>
                          </th>
                          <th>ID Commande</th>
                          <th>Client</th>
                          <th>Statut</th>
                          <th>Pays</th>
                          <th>
                            Total
                            <a @click="sortByTotal()" style="cursor:pointer">
                              <i  class="fas fa-sort-up blue" v-if="this.search.total === 'asc'"></i>
                              <i class="fas fa-sort-down blue" v-if="this.search.total === 'desc'"></i>
                            </a>
                          </th>  
                          <th>Date</th>
                          <th v-if="$gate.isLocalStore()">Statut Livraison</th>
                          <th>Actions</th>
                      </thead>
                      <tbody>
                        <tr v-if="!isLoading" v-for="order in paginatedOrders" :key="order.id">
                          <td>
                            <!-- <input type="checkbox" v-model="order.case"> -->
                            <div class="n-chk align-self-center text-center">
                              <div class="form-check">
                                <input type="checkbox"
                                  class="form-check-input contact-chkbox primary"
                                  :id="'checkbox_' + order.id"
                                  :value="order.id"
                                  :checked="selectedOrderIds.includes(order.id)"
                                  @change="selectIndividualCase(order.id)"
                                />
                                <label class="form-check-label" :for="'checkbox_' + order.id"></label>
                              </div>
                            </div>
                          </td>
                          <td>{{ order.id }}</td>
                          <td>{{ order.billing['last_name'] }} {{ order.billing['first_name'] }}  </td>
                          <td>{{ order.status}} </td> 
                          <td>{{ order.billing['country'] }}</td>
                          <td>{{ order.total | prix}}</td>
                          <td>{{ order.date_created | myDate  }} </td>
                          <td v-if="$gate.isLocalStore()">
                            <div @click="showStatutDropdown(order)"
                              :class="{
                                'status-grey': order.statut_livraison.status === 'Pas commencer',
                                'status-red':  order.statut_livraison.status === 'Perdu',
                                'status-green':  order.statut_livraison.status === 'Livrer',
                                'status-yellow': order.statut_livraison.status !== 'Pas commencer' && order.statut_livraison.status !== 'Perdu' 
                                  && order.statut_livraison.status !== 'Livrer' }"
                              style="display: inline-block; border: 1px solid; padding: 5px; cursor: pointer;">
                              {{ order.statut_livraison.status }}
                            </div>
                            <div v-if="selectedOrderId === order.id">
                              <select class="form-select" v-model="order.statut_livraison_id" @change="updateStatutLivraison(order)">
                                <option v-for="statutLivraison in statutLivraisons" :value="statutLivraison.id" :key="statutLivraison.id">
                                  {{ statutLivraison.status }}
                                </option>
                              </select>
                            </div>
                          </td>

                          <td>
                            <!-- Edit (local store only)-->
                            <button v-if="$gate.isLocalStore()" class="btn btn-info" @click="EditOrder(order)">
                              <i class="fa-solid fa-edit fa-fw"></i>
                            </button>
                            <!-- Status-->
                            <button v-if="!$gate.isLocalStore()" class="btn btn-info btn-sm" @click="modifierOrder(order)">
                              <i class="fa-solid fa-edit fa-fw"></i>
                            </button>
                            <!-- <button  v-if="$gate.isLocalStore()" class="btn btn-sm btn-success" @click="downloadPDF(order)">
                               <i class="fas fa-file-pdf"></i>
                               Exporter
                            </button> -->
                            <button class="btn btn-danger btn-sm" @click="deleteOrder(order)">
                              <i class="fa-solid fa-trash"></i>
                            </button>
                            <!-- detail-->
                            <button class="btn btn-secondary btn-sm" @click="showOrderDetails(order)">
                              <i class="fa-solid fa-eye"></i>
                            </button>
                            <!-- if status is completed ,show the button of 'generate invoice'-->
                            <button v-if="order.status === 'completed' && order.isFactured === false " class="btn btn-warning btn-sm" @click="generateInvoice(order)">
                              <i class="fa-solid fa-file-invoice-dollar"></i>
                            </button>
                            <button v-if="order.status === 'pending' && !isAssigned(order.id)" class="btn btn-success btn-sm" @click="ouvrirModalAssigner(order)">
                              <i class="nav-icon fa-solid fa-people-carry-box"></i>
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
                          <option value="modifier">Modifier</option>
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
      <!-- detail modal-->
      <div v-if="orderDetails" class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="orderDetailsModalLabel">Détails de la commande</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" @click="closeDetailsModal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row mb-3">
                <div class="col-md-7">
                  <h5 class="mb-3">Information du client:</h5>
                  <p><strong>Nom:</strong>{{ orderDetails.billing['last_name'] }} {{ orderDetails.billing['first_name'] }}</p>
                  <p><strong>Email:</strong> {{ orderDetails.billing['email'] }}</p>
                  <p><strong>Telephone:</strong> {{ orderDetails.billing['phone'] }}</p>
                  <p><strong>Adresse:</strong> {{ orderDetails.billing['address_1'] }}</p>
                  <p><strong>Pays:</strong> {{ orderDetails.billing['country'] }}</p>
                </div>
                <div class="col-md-5">
                  <h5 class="mb-3">Information de la commande:</h5>
                  <p><strong>Status:</strong> {{ orderDetails.status }}</p>
                  <p><strong>Date:</strong> {{ orderDetails.date_created | myDate }}</p>
                </div>
              </div>
              <hr>
              <div class="row mb-3">
                <div class="col-md-12">
                  <h5 class="mb-3">Produits:</h5>
                  <table class="table table-striped">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Produit</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Total</th>
                      </tr>
                    </thead>
                    <tbody >
                      <tr  v-for="(item,itemIndex) in paginatedLinesItems" :key="itemIndex">
                        <td>{{ item.name }}</td>
                        <td>{{ item.quantity }}</td>
                        <td>{{ item.price | prix }}</td>
                        <td>{{ item.total | prix }}</td>
                      </tr>
                    </tbody>
                    <tfoot class="bg-info">
                        <tr>
                            <td colspan="3" class="text-right"><strong>Total Cost:</strong></td>
                            <td colspan="2">{{ orderDetails.total | prix }}</td>
                        </tr>
                    </tfoot>
                  </table>
                  <!-- Paginations-->
                  <div class="row">
                    <div class="col-md-12">
                      <nav >
                        <ul class="pagination">
                          <li class="page-item" :class="{ disabled: lineItemsPagination.currentPage === 1 }">
                            <a class="page-link" href="#" aria-label="Précédent" @click.prevent="changePageAjout(lineItemsPagination.currentPage - 1)">
                              <span aria-hidden="true">&laquo;</span>
                              <span class="sr-only">Précédent</span>
                            </a>
                          </li>
                          <li class="page-item" v-for="page in lineItemsPagination.totalPages" :key="page" :class="{ active: page === lineItemsPagination.currentPage }">
                            <a class="page-link" href="#" @click.prevent="changePageAjout(page)">{{ page }}</a>
                          </li>
                          <li class="page-item" :class="{ disabled: lineItemsPagination.currentPage === lineItemsPagination.totalPages }">
                            <a class="page-link" href="#" aria-label="Suivant" @click.prevent="changePageAjout(lineItemsPagination.currentPage + 1)">
                              <span aria-hidden="true">&raquo;</span>
                              <span class="sr-only">Suivant</span>
                            </a>
                          </li>
                        </ul>
                      </nav>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger rounded-pill px-4" data-dismiss="modal" @click="closeDetailsModal">Fermer</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal pour modifier le status d'une commande-->
      <div v-if="orderToModify" class="modal fade" id="modifierOrderModal" tabindex="-1" role="dialog" aria-labelledby="modifierOrderModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modifierOrderModalLabel">Modifier le status de la commande</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer" @click="closeModifierOrderModal()">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <select class="form-select" v-model="orderToModify.status">
                  <option value="">Selectionner un statut</option>
                  <option v-for="status in statusList" :key="status" :value="status">{{ status }}</option>
                </select>
                <span class="text-danger" v-if="orderToModify.status === ''">Veuillez sélectionner un statut</span>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary rounded-pill px-4" @click="updateOrderStatus()" :disabled="orderToModify.status === ''">Enregistrer</button>
              </div>
            </div>
          </div>
      </div>  
       <!-- Assigner livreur Modal -->
      <div class="modal fade" id="assignerLivreurModal" tabindex="-1" role="dialog" aria-labelledby="assignerLivreurModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 v-if="!editMode" class="modal-title" id="assignerLivreurModalLabel">Assigner un livreur à cette commande</h5>
              <h5 v-else class="modal-title" id="assignerLivreurModalLabel">Modifier un produit</h5>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fermer" @click="closeAssignerLivreurModal()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="assigner-form" @submit.prevent="assignerLivreur()">
              <div class="modal-body">
                <div class="form-group">
                      <label for="store">Commande:</label>
                      <a class="form-control">{{ commande.id }}</a>
                    </div>
                <div class="form-group">
                  <label for="societeTransport">Societe de transport:</label>
                      <select class="form-control" v-model="societeTransportId" @change="loadLivreurs">
                        <option value="">Sélectionnez une société de transport</option>
                        <option v-for="societeTransport in societeTransports" :value="societeTransport.id">{{ societeTransport.name }}</option>
                      </select>
                </div>
                <div class="form-group">
                  <label for="livreur">Livreur:</label>
                      <select class="form-control" v-model="livreurId" :disabled="!societeTransportId">
                        <option v-for="livreur in livreurs" :value="livreur.id">
                          <span :class="{ 'bold-text': true }">{{ livreur.matricule }}</span>
                          <span>{{ livreur.user.name }}</span>
                        </option>
                      </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger rounded-pill px-4" data-dismiss="modal" @click="closeAssignerLivreurModal()">Annuler</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4">Assigner</button>
                <!-- <button type="submit" class="btn btn-primary" v-if="editMode"> <i class="fa fa-edit white"></i></button> -->
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
    store_id:null,
    orders: [],
    orderDetails: null,
    orderToModify: null,
    status: '',
    statusList: [ 'pending','processing','on-hold','completed','cancelled','refunded',],
    search:{
      client: '',
      status: '',
      date: '',
      country: '',
      total:'asc'
    },
    countries :['MA','CI','DZ','TUN'],
    dateSortOrder:['Les 7 derniers jours','Les 30 derniers jours','Les 3 derniers mois','Les 6 derniers mois','Les 12 derniers mois'],
    lineItemsPagination: {
      currentPage: 1,
      perPage: 3,
      totalPages: 0,
    },
    //pagination
    pagination:{
      current_page:1,
      per_page:10,
      total_pages:0,
    },
    selectedOrderIds: [], // Ajout de la liste des IDs des orders sélectionnés
    allCase: false,
    actionGrouper: '', // Variable pour stocker l'action sélectionnée
    boutonAppliquer: '', // Variable pour stocker l'action sélectionnée
    modalVisible: false,
    societeTransports: [],
    societeTransportId: null,
    livreurs: [],
    livreurId: '',
    order_id:'',
    livreurCommandes: [],
    commande: '',
    accepted: '',
    editMode: false,
    assigned:false,
    statutLivraisons: [],
    selectedOrderId: null,
    isLoading:true,
  };
},
computed: {
  paginatedOrders(){
        this.pagination.total_pages = Math.ceil(this.filteredOrders.length / this.pagination.per_page);
        return this.filteredOrders.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
     },
  filteredOrders() {
    let filteredOrders = this.orders;
    if (this.search.client && this.search.client !== '') {
      filteredOrders = filteredOrders.filter((order) => {
        return order.billing['last_name'].toLowerCase().includes(this.search.client.toLowerCase()) || order.billing['first_name'].toLowerCase().includes(this.search.client.toLowerCase());
      });
    }

    if (this.search.status && this.search.status !== '') {
      filteredOrders = filteredOrders.filter((order) => {
        return order.status.toLowerCase().includes(this.search.status.toLowerCase());
      });
    }


    if (this.search.country && this.search.country !== '') {
      filteredOrders = filteredOrders.filter((order) => {
        return order.billing['country'].toLowerCase().includes(this.search.country.toLowerCase());
      });
    }

    // date filter based on dateSortOrder
    if (this.search.date && this.search.date !== '') {
      let date = new Date();
      switch (this.search.date) {
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
      filteredOrders = filteredOrders.filter((order) => {
        return new Date(order.date_created) > date;
      });
    }

    // sort by total
    if (this.search.total && this.search.total !== '') {
      if (this.search.total === 'asc') {
        filteredOrders = filteredOrders.sort((a, b) => {
          return a.total - b.total;
        });
      } else {
        filteredOrders = filteredOrders.sort((a, b) => {
          return b.total - a.total;
        });
      }
    }

    return filteredOrders;  

  },
  paginatedLinesItems(){
    if(this.orderDetails == null) return;

    this.lineItemsPagination.totalPages = Math.ceil(this.orderDetails.line_items.length / this.lineItemsPagination.perPage) ;
    const index = (this.lineItemsPagination.currentPage - 1) * this.lineItemsPagination.perPage;
    return this.orderDetails.line_items.slice(index, index + this.lineItemsPagination.perPage);
  }
},
created() {
  console.log("Composant monté.");
  // get store from current boutique
  if(!this.$store.getters.currentBoutique && !this.$gate.isSuperAdmin() && !this.$gate.isResponsible(this.$store.getters.currentBoutique)){
    this.$router.push('/404');
    return;
  }

  this.store_id = this.$store.getters.currentBoutique.id; 
  this.loadOrders();
  console.log(this.orders);
},
mounted(){
  this.loadsocieteTransports();
  this.loadLivreurs();
  this.loadlivreurCommandes();
  this.loadStatutLivraison();
},
 methods: {

  //pagination
  changePageAjout(page) {
    this.lineItemsPagination.currentPage = page;
  },
  //pagination
  changePage(page){
         this.pagination.current_page = page;
      },
  //Traitement des cases cocher
  selectAllCases() {
    if (this.allCase) {
      const start = (this.pagination.current_page - 1) * this.pagination.per_page;
      const end = start + this.pagination.per_page;
      this.selectedOrderIds = this.filteredOrders.slice(start, end).map((order) => order.id);
    } else {
      this.selectedOrderIds = [];
    }
    this.updateAllCaseStatus();
  },
  selectIndividualCase(orderId) {
    const index = this.selectedOrderIds.indexOf(orderId);

    if (index === -1) {
      // Si le produit n'est pas déjà sélectionné, l'ajouter à la liste
      this.selectedOrderIds.push(orderId);
    } else {
      // Si le produit est déjà sélectionné, le retirer de la liste
      this.selectedOrderIds.splice(index, 1);
    }
    this.updateAllCaseStatus();
  },
  updateAllCaseStatus() {
    this.allCase = this.filteredOrders.length === this.selectedOrderIds.length;
    console.log('IDs des orders sélectionnés :', this.selectedOrderIds);
    console.log('allcase:', this.allCase);
    },
  applyAction() {
    if (this.actionGrouper === 'modifier') {
      if (this.selectedOrderIds.length > 0) { 
        this.boutonAppliquer = 'modifier';
        this.status= '';
      } 
      else {
        Swal.fire(
        'Aucune commande sélectionné !',
        'Veuillez choisir une ou plusieurs commandes!',
        'warning'
        );
      }
    } else if (this.actionGrouper === 'supprimer') {
      if (this.selectedOrderIds.length > 0) { 
        this.boutonAppliquer = 'supprimer';
        this.deleteSelectedOrders(); 
      } 
      else {
        Swal.fire(
          'Aucun commande sélectionné !',
          'Veuillez choisir une ou plusieurs commandes!',
          'warning'
          );
      }
    }
  },
  getOrder(orderId) {
    const order = this.orders.find((order) => order.id === orderId);
    if (order) {
      const { id, billing: { first_name, last_name } } = order;
      return `${id} ${first_name} ${last_name}`;
    } else {
      return null; // Retourne null si la commande n'est pas trouvée
    }
  },
  // Méthode pour supprimer un produit sélectionné de la liste
  removeSelectedOrder(orderId) {
    const index = this.selectedOrderIds.indexOf(orderId);
    if (index !== -1) {
      this.selectedOrderIds.splice(index, 1);
    }
    console.log('IDs des commandes sélectionnés :', this.selectedOrderIds);
  },
  // Méthode pour mettre à jour les produits sélectionnés avec une nouvelle catégorie ou marque
  updateSelectedOrders() {
    //at least one category
    const orders = {
      ids: this.selectedOrderIds,
      status: this.status,
      store: this.store_id,
    }
    this.$Progress.start();
    axios.put('api/orders/modificationEnMasse', orders)
    .then((response) => {
      console.log(response.data);
      this.loadOrders();
      this.$Progress.finish();
      this.ProductValidationErrors = {};
      this.cancelUpdate();
      Swal.fire(
      'Bon travail!',
      'Commandes mis à jour avec succès!',
      'success'
      );
      // Réinitialiser les données de modification groupée
    })
    .catch((error) => console.log(error));
  },
  // Méthode pour supprimer en masse les produits sélectionnés
  deleteSelectedOrders(){
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
        axios.delete('/api/orders/supprimerEnMasse',{ 
            data: 
            {
              ids: this.selectedOrderIds,
              store: this.store_id
            }
            })
        .then((response) => {
          console.log(response.data);
          vm.$Progress.finish();
          vm.loadOrders();
          this.cancelUpdate();
          Swal.fire(
            'Supprimé!',
            'Les commandes ont été supprimé.',
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
    this.selectedOrderIds = []; // Vider la liste des produits sélectionnés
    this.status = '';
    this.form.allCase= '';
    this.boutonAppliquer=false;
  },
  //
  loadOrders() {
    axios.get(`api/order/${this.store_id}`)
      .then((response) => {
        this.orders = response.data;
        
        //Specification de mongadget
        if(this.$store.getters.currentBoutique.store_url === 'https://mongadget.ma'){
          this.orders.map((order) => {
            if(order.meta_data[0].key === "_billing_nom_complet"){
              let name = order.meta_data[0].value.split(" ");
              order.billing['last_name'] = '';
              order.billing['first_name'] = name[0];
              if(name.length > 1){
                order.billing['last_name'] = name[1];
              }
            }

            if(order.meta_data[1].key === "_billing_adresse_complet"){
              order.billing['address_1'] = order.meta_data[1].value;
            }

          });
        }
        this.isLoading = false;
        console.log(this.orders);
      })
      .catch((error) => {
        console.log('fetch error',error);
      });
  },
  loadStatutLivraison(){
    console.log(axios.get('api/statutLivraison/'));
            axios.get('api/statutLivraison/')
            .then((response =>{
                console.log(response.data.statusLivraisonsOrders);
                this.statutLivraisons= response.data.statusLivraisonsOrders;
            }))
            .catch((error) => console.log(error));
        },
        showStatutDropdown(order) {
          // Fermez la liste déroulante si elle est déjà ouverte pour cette commande
            if (this.selectedOrderId === order.id) {
              this.selectedOrderId = null;
            } else {
              // Ouvrez la liste déroulante pour la commande sélectionnée
              this.selectedOrderId = order.id;
            }
        },
        async updateStatutLivraison(order) {
            try {
                await axios.put(`/api/updateStatutLivraison/${order.id}`, { 
                  statut_livraison_id: order.statut_livraison_id ,
                  store_id : this.store_id,
                });
                this.loadOrders();
                this.selectedOrderId = null; // Fermez la liste déroulante après la mise à jour réussie
            } 
            catch (error) {
            // Afficher l'erreur dans la console en cas d'erreur d'appel API
            console.error(error);
            if(error.response.status == 422){
              Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: "Cette commande n'a pas de livreur assigner!",
            });
            }  
            if(error.response.status == 423){
              Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text:  "Cette commande n'a pas encore ete accepter par un livreur!",
            });
            }  
            this.loadOrders();
            this.selectedOrderId = null; // Fermez la liste déroulante après la mise à jour réussie
          }
        },
       
        isAssigned(commandeId) {
          // return this.livreurCommandes.some((livreurCmd) => livreurCmd.order_id === commandeId);
          return this.livreurCommandes.some((livreurCmd) => livreurCmd.order_id === commandeId 
                              && (livreurCmd.accepted === 1 || livreurCmd.accepted === 0));
        },

  ouvrirModalAssigner(order) {
      // Réinitialiser les champs du formulaire\
      this.commande = order;
      this.order_id = this.commande.id;
      this.societeTransportId = null;
      this.livreurs = [];
      this.livreurId = null;
      this.$nextTick(() => {
          $('#assignerLivreurModal').modal('show');
         }); 
      },
  loadsocieteTransports(){
          axios.get(`api/societeTransport/${this.store_id}`)
          .then(({data}) => {
            (this.societeTransports = data.societeTransport);
            (this.boutique = data.boutique);
            console.log(this.societeTransports);
            })
          .catch(({response}) => console.log(response.data));
      },
      loadLivreurs() {
        if (this.societeTransportId) {
          // Appeler l'API pour récupérer les livreurs de la société de transport
          axios
            .get(`/api/livreur/${this.societeTransportId}`)
            .then((response) => {
              // Récupérer la liste des livreurs depuis la réponse de l'API
              this.livreurs =response.data.livreur;
            })
            .catch((error) => {
              // Gérer les erreurs
              console.error(error);
            });
        } else {
          this.livreurs = []; // Réinitialiser la liste des livreurs si aucune société de transport n'est sélectionnée
        }
      },
      loadlivreurCommandes(){
        axios.get('api/livreurCommande/')
          .then(({data}) => {
            (this.livreurCommandes = data.data);
            console.log(this.livreurCommandes);

            })
          .catch(({response}) => console.log(response.data));
      },
      downloadPDF(order) {
        console.log(axios.get(`/api/facture/download/${this.store_id}/${order.id}`));
        console.log(axios.get(`/api/download/${order.id}`));
        // axios.get(`/api/transaction/download/${order.id}`, {responseType: 'blob'});
        // .then(response => {
        // // Créer un blob à partir des données de la réponse
        // const blob = new Blob([response.data], { type: 'application/pdf' });

        // // Créer un lien pour le téléchargement du blob
        // const link = document.createElement('a');
        // link.href = window.URL.createObjectURL(blob);
        // link.target = '_blank';
        // link.download = 'bon_de_commande.pdf'; 

        // document.body.appendChild(link);
        // link.click();
        // document.body.removeChild(link);
        // window.URL.revokeObjectURL(link.href);
        // })
        // .catch(error => {
        //     console.log(error);
        // });
        
  },          
      closeAssignerLivreurModal() {
        this.modalVisible = false;
        $('#assignerLivreurModal').modal('hide');
      },
      assignerLivreur() {
      //  event.preventDefault();
        this.accepted = 0;
        if (this.order_id && this.livreurId) {
          // Créez un objet contenant les données de la livreur à envoyer
          const livreur_CommandeData = {
            livreurId: this.livreurId,
            order_id: this.order_id,
            accepted: this.accepted,
          };

          this.$Progress.start();
          axios
            .post('api/livreurCommande', livreur_CommandeData)
            .then((response) => {
              console.log(response.data);
              this.loadlivreurCommandes();
              this.$Progress.finish();
              Swal.fire('Bon travail!', 'Livreur assigné avec succès!', 'success');
              $('#assignerLivreurModal').modal('hide');
            })
            .catch(({ response }) => {
                    Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Cette commande est déjà attribuée à un livreur!',
                });
                console.log(response.data);
                });
        } else {
          // Gérer le cas où les identifiants ne sont pas définis
          console.error("Identifiants de commande et/ou de livreur manquants.");
        }
  },
  modifierOrder(order) {
    this.orderToModify = Object.assign({}, order);
    this.$nextTick(() => {
      $('#modifierOrderModal').modal('show');
    }); 
    },
  closeModifierOrderModal() {
    this.orderToModify = null;
    $('#modifierOrderModal').modal('hide');
  },
  updateOrderStatus() {
    // progress bar
    this.$Progress.start();
    axios.put(`api/order/${this.orderToModify.id}`, { status: this.orderToModify.status,store:this.store_id })
      .then((response) => {
        console.log(response.data);
        //update on the orders list
        let index = this.orders.findIndex((order) => {
          return order.id === this.orderToModify.id;
        });
        this.orders[index].status = this.orderToModify.status;
        //swal success
        Swal.fire({
          icon: 'success',
          title: 'Status de la commande mise à jour avec succès',
          showConfirmButton: false,
          timer: 1500
        })
        // progress bar
        this.$Progress.finish();
        this.closeModifierOrderModal();
      })
      .catch((error) => {
        console.log('fetch error',error);
      });
  }, 

   
  modifierOrders(orders) {
    // this.orders = orders.map((order) => ({ ...order, selectionnee: false }));
    this.ordersModifiees = Object.assign({}, orders);
    // this.ordersModifiees = orders;
    this.$nextTick(() => {
      $('#modifierOrdersModal').modal('show');
    });
  },

  deleteOrder(order) {
    // swal confirm
    Swal.fire({
      title: 'Êtes-vous sûr?',
      text: "Vous ne pourrez pas revenir en arrière!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor:'#3085d6',
      cancelButtonColor:'#d33',
      confirmButtonText:'Oui, supprimez-la!',
      cancelButtonText: 'Annuler',
    }).then((result) => {
      if (result.value) {
        // progress bar
        this.$Progress.start();
        axios.delete(`api/order/${this.store_id}/${order.id}`)
          .then((response) => {
            console.log(response.data);
            //remove from the orders list
            let index = this.orders.findIndex((o) => {
              return o.id === order.id;
            });
            this.orders.splice(index, 1);
            //swal success
            Swal.fire({
              icon: 'success',
              title: 'La commande a été supprimée',
              showConfirmButton: false,
              timer: 1500
            })
            // progress bar
            this.$Progress.finish();
          })
          .catch((error) => {
            console.log('fetch error',error);
          });
      }
    })
  },
  showOrderDetails(order) {
    this.orderDetails = order;
    this.$nextTick(() => {
      $('#orderDetailsModal').modal('show');
    });
  },
  sortByTotal() {
    this.search.total = this.search.total === 'asc' ? 'desc' : 'asc';
  },
  addNewOrder() {
    this.$router.push({ name: 'order_new' });
  },
  EditOrder(order) {
    this.$router.push({ name: 'order_edit',query: {order:order.id } });
  },
  exportOrders() {
    // progress bar
    this.$Progress.start();
    axios.get(`api/order/export/${this.store_id}`,{
      responseType: 'blob',
    })
      .then((response) => {
        console.log(response.data);
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        const file_name = response.headers['content-disposition'].split(';')[1].split('=')[1].replace(/\"/gi, '');
        link.setAttribute('download', file_name);
        document.body.appendChild(link);
        link.click();
        //remove the link
        link.parentNode.removeChild(link);
        this.$Progress.finish();
      })
      .catch((error) => {
        this.$Progress.fail();
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: "Quelque chose n'a pas fonctionné!",
        });
        console.log('fetch error',error);
      });
  },
  closeDetailsModal() {
    this.orderDetails = null;
    this.lineItemsPagination = {
      currentPage: 1,
      perPage: 3,
      totalPages: 0,
    },

    $('#orderDetailsModal').modal('hide');
  },
  generateInvoice(order){
    const data = {
      store:this.store_id,
      order_id:order.id,
    }

    //request
    axios.post(`api/facture/process`,data)
      .then((response) => {
        console.log(response.data);
        //swal success
        Swal.fire({
          icon: 'success',
          title: 'Invoice generated successfully',
          showConfirmButton: false,
          timer: 1500
        })
      })
      .catch((error) => {
        console.log('fetch error',error)
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong!',
        });
        
      });

  },
},
}

</script >
<style>

#assigner-form .form-group {
  display: grid;
  grid-template-columns: 1fr 2fr;
  grid-gap: 10px;
  margin-bottom: 10px;
}

#assigner-form label {
  font-size: 14px;
  font-weight: bold;
  align-self: center;
}

#assigner-form input, #assigner-form select {
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 3px;
  font-size: 14px;
}

.form-horizontal .control-label{
text-align: left;
}
.list-group{
margin-top: 30px;
}

.bold-text {
  font-weight: bold;
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
.status-red {
    display: inline-block; 
    border: 1px solid red; 
    color: red;
    background-color: rgb(241, 201, 195); 
    padding: 5px;
    border-radius: 5px; 
    border-style: dashed;
}

.status-grey {
    display: inline-block; 
    border: 1px solid grey ; 
    color: rgba(33, 28, 28, 0.465);
    background-color: #E7E8EA; 
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
  font-size: 13px; 
}

/* Modifier la taille de police pour les liens de pagination */
.pagination .page-link {
  font-size: 12px; 
}

/* Modifier la taille de police pour les titres de modal */
.modal-title {
  font-size: 20px; 
}
.search-select {
  font-size: 13px; /* Modifiez selon la taille de police souhaitée */
}
.spinner-container {
    position: fixed;
    top: 100%; /* Ajustez cette valeur pour centrer verticalement */
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999; /* Assurez-vous que le spinner est au-dessus de tout le reste */
    background-color: rgba(255, 255, 255, 0.7); /* Un arrière-plan semi-transparent pour le contraste */
}
.selected-orders {
  border: 1px solid #ccc;
  padding: 10px;
  margin-bottom: 20px;
  display: flex;
  flex-direction: column; /* Afficher les éléments en colonnes */
}
.scrollable-orders {
  max-height: 400px; /* Hauteur maximale à partir de laquelle le défilement apparaîtra */
  overflow-y: auto; /* Ajout du défilement vertical si nécessaire */
}
.selected-orders div {
  margin-bottom: 10px;
}
</style>
