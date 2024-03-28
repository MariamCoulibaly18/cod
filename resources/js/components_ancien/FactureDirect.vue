<template>
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="background-color: #2f4fb1; display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
                <h3 class="card-title text-white">Factures par Boutique Directe</h3>
                <!--Add new Facture Button -->
                <div class="card-tools">
                    <button class="btn  btn-light float-right" @click="showAddFactureModal"  style="color: #01356F;" >
                        Nouveau <i class="ti ti-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <!-- search -->
                <div class="row m-3 ">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Rechercher par client" v-model="search.name">
                    </div>
                    <div class="col">
                        <select class="form-select search-select" v-model="search.status">
                            <option value="">Selectionner le status</option>
                            <option value="ouvert">Ouvert</option>
                            <option value="ferme">Fermé</option>
                        </select>
                    </div>
                    <div class="col">
                        <select class="form-select search-select" v-model="search.payment_status">
                            <option value="">Sélectionner le statut du paiement</option>
                            <option value="paye">Payé</option>
                            <option value="incomplet">Incomplet</option>
                        </select>
                    </div>

                    <!-- date (last 3days , last week ...)-->
                    <div class="col">
                        <select class="form-select search-select" v-model="search.date">
                            <option value="">Selectionner une date</option>
                            <option value="last_3_days">Les 3 derniers jours</option>
                            <option value="last_week">La semaine dernière</option>
                            <option value="last_month">Le mois dernier</option>
                            <option value="last_3_months">Les 3 derniers mois</option>
                            <option value="last_6_months">Les 6 derniers mois</option>
                            <option value="last_year">L'année dernière</option>
                        </select>
                    </div>
                </div>
                <table class="table table-hover text-nowrap">
                    <div class="spinner-container" v-if="isLoading" style="top: 60%;transform: translate(-50%, -50%);">
                     <loader></loader>
                    </div>
                    <thead>
                        <th>ID</th>
                        <th>Client</th>
                        <th>
                            Total 
                        </th>
                        <th>
                            Montant dû 
                            <a @click="sortByDue" style="cursor: pointer;">
                              <i  class="fas fa-sort-up blue" v-if="this.search.due === 'asc'"></i>
                              <i class="fas fa-sort-down blue" v-if="this.search.due === 'desc'"></i>
                            </a>
                        </th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Statut du paiement</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <tr v-if="!isLoading" v-for="facture in paginatedFactureDirectes" :key="facture.id">
                            <td>{{facture.id}}</td>
                            <td>{{facture.client}}</td>
                            <td>{{facture.total | prix}}</td>
                            <td>{{facture.due | prix }}</td>
                            <td>{{facture.date | myDate}}</td>
                            <td>
                                <span class="badge badge-success" v-if="facture.status == 'ouvert'">
                                    Ouvert
                                </span>
                                <span class="badge badge-warning" v-else-if="facture.status == 'ferme'">
                                    Fermé
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-success" v-if="facture.payment_status == 'paye'">
                                    Payé
                                </span>
                                <span class="badge badge-warning" v-else="facture.payment_status == 'incomplet'">
                                    Incomplet
                                </span>
                            </td>
                            <td>
                                <button v-if="facture.status == 'ouvert'" class="btn btn-sm btn-warning" @click="fermerFacture(facture)">
                                    <!-- fermer-->
                                    <i class="fas fa-check"></i>
                                    Fermer
                                </button> 
                                <button v-else class="btn btn-sm btn-success" @click="ouvrirFacture(facture)">
                                    <!-- ouvrir-->
                                    <i class="fas fa-check"></i>
                                    Ouvrir
                                </button>   
                                <!-- view payment history -->
                                <button class="btn btn-sm btn-secondary" @click="viewPaymentHistory(facture)">
                                    <i class="fas fa-money-bill"></i>
                                    Trace de paiement
                                </button>
                                <!-- export pdf -->
                                <button class="btn btn-sm btn-success" @click="downloadPDF(facture)">
                                    <i class="fas fa-file-pdf"></i>
                                    Exporter PDF
                                </button>
                                <!-- envoyer par email -->
                                <button class="btn btn-sm btn-primary" @click="sendEmail(facture)">
                                    <i class="fas fa-envelope"></i>
                                    Envoyer par email
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
    <!--Payment trace modal-->
    <div class="modal fade" id="paymentHistoryModal" tabindex="-1" aria-labelledby="paymentHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentHistoryModalLabel">Historique des paiements</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" @submit.prevent="addPayment">
                        <div class="d-flex align-items-center mb-3" v-if="factureEditee.status =='ouvert' && factureEditee.payment_status == 'incomplet'">
                            <input type="number" class="form-control" placeholder="Enter amount" v-model="payementAmount">
                            <button class="btn btn-primary ms-2" type="submit">
                                <i class="fas fa-plus"></i>
                                Ajouter un paiement
                          </button>
                        </div>
                    </form>
                    <div class="payment-history">
                        <div class="payment-history-item" v-for="payement in payements.history" :key="payement.id">
                            <div class="payment-history-item-header">
                                <p class="payment-history-item-date">{{ payement.date | myDate }}</p>
                                <button class="btn btn-sm btn-secondary btn-delete-payement" v-if="factureEditee.status =='ouvert'" @click="deletePayment(payement)">
                                    <i class="fa-solid fa-rotate-right"></i>
                                </button>
                            </div>
                            <div class="payment-history-item-details">
                                <p class="payment-history-item-amount">{{ payement.amount | prix }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="payment-summary">
                        <div class="payment-summary-row">
                            <span class="payment-summary-label">Total payé:</span>
                            <span class="payment-summary-value">{{ payements.total | prix }}</span>
                        </div>
                        <div class="payment-summary-row">
                            <span class="payment-summary-label">Due:</span>
                            <span class="payment-summary-value">{{ payements.due | prix }}</span>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!--Add new Facture modal-->
    <div class="modal fade" id="addFactureModal" tabindex="-1" aria-labelledby="addFactureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une nouvelle facture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <form action="" @submit.prevent="createFacture">
                    <div class="modal-body">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="client">Client</label>
                                        <select name="client" id="client" class="form-control" v-model="facture.client">
                                            <option value="">Selectionner un client</option>
                                            <option v-for="client in clients" :key="client.id" :value="client.id">
                                                {{ client.first_name }} {{ client.last_name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" v-model="facture.email">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-md-6">
                                       <div class="form-group">
                                           <label for="adress">Adresse : </label>
                                           <input type="text" class="form-control" id="adress" disabled v-model="facture.adresse" placeholder="Adresse">
                                       </div>
                                   </div>
                                    <div class="col col-md-6">
                                        <div class="form-group">
                                            <label for="phone">telephone : </label>
                                            <input type="text" class="form-control" id="phone" disabled v-model="facture.telephone" placeholder="Phone">
                                        </div>
                                    </div>
                                </div>
                                <!-- products -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product">Produit : </label>
                                            <select class="form-control" id="product" v-model="product.id" >
                                                <option value="" selected>-- Choisir un produit --</option>
                                                <option v-for="pdt in products_list" :key="pdt.id" :value="pdt.id">
                                                    {{ pdt.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- le prix du produit -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="price">Prix : </label>
                                            <input type="number" class="form-control" id="price" v-model="product.price" disabled placeholder="Prix">
                                        </div>
                                    </div>
                                    <!-- la quantité du produit -->
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="quantity">Quantité : </label>
                                            <input type="number" min="1" class="form-control" :class="[quantityClass]" id="quantity" v-model="product.quantity" placeholder="Quantité" :disabled="product.id == ''">
                                        </div>
                                    </div>
                                    <!-- ajouter le produit à la liste -->
                                    <div class="col-md-1">
                                        <br/>
                                        <a class="btn btn-success mt-1 w-100" @click="addProduct">
                                            <i class="fa fa-plus white" ></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- list of products -->
                                <div class="row" v-if="facture.products.length > 0">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Produit</th>
                                                    <th>Prix</th>
                                                    <th>Quantité</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody style="max-height: 100px; overflow-y: auto;" >
                                                <tr v-for="product in paginatedLinesItems " :key="product.id">
                                                    <td>{{ product.name }}</td>
                                                    <td>{{ product.price | prix }}</td>
                                                    <td>{{ product.quantity }}</td>
                                                    <td>{{ product.price * product.quantity | prix}}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger" @click="deleteProduct(product)">
                                                            <i class="ti ti-trash-x"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!-- total -->
                                            <tfoot class="bg-info">
                                                <tr>
                                                    <td colspan="3" class="text-right">Total</td>
                                                    <td colspan="2">{{ facture.total | prix}}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                     <!-- Paginations-->
                                     <div v-if="facture.products.length > 0" class="row">
                                            <div class="col-md-12">
                                                <nav >
                                                <ul class="pagination">
                                                    <li class="page-item" :class="{ disabled: lineItemsPagination.currentPage === 1 }">
                                                    <a class="page-link" href="#" aria-label="Previous" @click.prevent="changePageAjout(lineItemsPagination.currentPage - 1)">
                                                        <span aria-hidden="true">&laquo;</span>
                                                        <span class="sr-only">Précédent</span>
                                                    </a>
                                                    </li>
                                                    <li class="page-item" v-for="pageAjout in lineItemsPagination.totalPages" :key="pageAjout" :class="{ active: pageAjout === lineItemsPagination.currentPage }">
                                                    <a class="page-link" href="#" @click.prevent="changePageAjout(pageAjout)">{{ pageAjout }}</a>
                                                    </li>
                                                    <li class="page-item" :class="{ disabled: lineItemsPagination.currentPage === lineItemsPagination.totalPages }">
                                                    <a class="page-link" href="#" aria-label="Next" @click.prevent="changePageAjout(lineItemsPagination.currentPage + 1)">
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
                        <button type="button" class="btn btn-danger" @click="resetForm">
                            <i class="fa fa-times"></i>
                            Annuler
                        </button>
                        <button class="btn btn-success" type="submit" :disabled="isSubmitDisabled" >
                            <i class="fa fa-check"></i>
                            Enregistrer
                        </button>
                    </div>
                </form> 
            </div>
        </div>    
    </div>

</div>
</template>

<script>
import Swal from 'sweetalert2';

export default {
    data: () => ({
    store_id:null,
    factures: [],
    clients: [],
    products: [],
    product: {
        id: '',
        name: '',
        price: 0,
        quantity: 1,
        sku: '',
    },
    payements: {
        history: [],
        total: 0,
        due: 0,
    },
    factureEditee: {},
    payementAmount: 0,
    facture: {
        client: '',
        email: '',
        telephone: '',
        adresse: '',
        products: [],
        factureProducts:[],
        total: 0,
        payement_status: 'incomplet',
    },
    search: {
        name: '',
        status: '',
        payment_status: '',
        date: '',
        total:'asc',
        due:'asc',
    },
    lineItemsPagination: {
        currentPage: 1,
        perPage: 3,
        totalPages: 0,
    },
    quantityClass: '',
    //pagination
    pagination:{
      current_page:1,
      per_page:5,
      total_pages:0,
    },
    isLoading:true,
}),
created(){
    console.log('Composant créé.');
    // get store from current boutique
    if(this.$store.getters.currentBoutique)
        this.store_id = this.$store.getters.currentBoutique.id;
    
    console.log(this.store_id);  
    this.loadFactures();
},
mounted(){
    this.loadClients();
    this.loadProducts();
},
watch:{
    'facture.client':function(){
        if(this.facture.client){
            let client = this.clients.find(client => client.id == this.facture.client);
            this.facture.email = client.email;
            this.facture.telephone = client.phone;
            this.facture.adresse = client.adress;
        }else{
            this.facture.email = '';
            this.facture.telephone = '';
            this.facture.adresse = '';
        }    
    },
    'product.id':function(){
        if(this.product.id){
            let product = this.products.find(product => product.id == this.product.id);
            this.product.name = product.name;
            this.product.price = product.price;
            this.product.quantity = 1;
            this.product.sku=product.sku;
        }else{
            this.product= {};
        }
    },
    'product.quantity':function(){
        if(this.product.id){
            let product = this.products.find(product => product.id == this.product.id);
            if(this.product.quantity > product.quantity){
                this.quantityClass = 'is-invalid';
            }else{
                this.quantityClass = '';
            }
        }
    },
},
computed : {
    paginatedFactureProcess(){
        this.pagination.total_pages = Math.ceil(this.filteredFactures.length / this.pagination.per_page);
        return this.filteredFactures.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
     },
    paginatedFactureDirectes(){
        this.pagination.total_pages = Math.ceil(this.filteredFactures.length / this.pagination.per_page);
        return this.filteredFactures.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
     },
    products_list(){
        let filtered = Object.assign([], this.products);
        filtered = filtered.filter(product => product.quantity > 0);
        //On veux retourner uniquement les produits qui n'ont pas été ajoutés à la liste par leur identifiant.
        this.facture.products.forEach(pdt => {
            filtered = filtered.filter(product => product.id != pdt.id);
        });
        return filtered;
    },
    isSubmitDisabled(){
        return this.facture.products.length == 0 || this.facture.total == 0.0 || this.facture.client == '' ;
    },
    paginatedLinesItems() {
        if (this.facture.products === undefined || this.facture.products.length === 0) {
            this.lineItemsPagination.totalPages = 0;
            return [];
        }

        this.lineItemsPagination.totalPages = Math.ceil(this.facture.products.length / this.lineItemsPagination.perPage);
        const index = (this.lineItemsPagination.currentPage - 1) * this.lineItemsPagination.perPage;
        return this.facture.products.slice(index, index + this.lineItemsPagination.perPage);
     },
    filteredFactures(){
        let filtered = Object.assign([], this.factures);
        //filter by name
        if(this.search.name != ''){
            filtered = filtered.filter(facture => facture.client.toLowerCase().includes(this.search.name.toLowerCase()));
        }
        //filter by status
        if(this.search.status != ''){
            filtered = filtered.filter(facture => facture.status == this.search.status);
        }
        //filter by payment status
        if(this.search.payment_status != ''){
                    filtered = filtered.filter(facture => {
                        return facture.payment_status == this.search.payment_status;
                    })
                }
        //filter by date
        if(this.search.date != ''){
            let date = new Date();
            let today = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
            let last_3_days = new Date(date.setDate(date.getDate() - 3)).toISOString().slice(0, 10);
            let last_week = new Date(date.setDate(date.getDate() - 4)).toISOString().slice(0, 10);
            let last_month = new Date(date.setDate(date.getDate() - 26)).toISOString().slice(0, 10);
            let last_3_months = new Date(date.setDate(date.getDate() - 60)).toISOString().slice(0, 10);
            let last_6_months = new Date(date.setDate(date.getDate() - 90)).toISOString().slice(0, 10);
            let last_year = new Date(date.setDate(date.getDate() - 180)).toISOString().slice(0, 10);
            switch(this.search.date){
                case 'last_3_days':
                    filtered = filtered.filter(facture => facture.date >= last_3_days && facture.date <= today);
                    break;
                case 'last_week':
                    filtered = filtered.filter(facture => facture.date >= last_week && facture.date <= today);
                    break;
                case 'last_month':
                    filtered = filtered.filter(facture => facture.date >= last_month && facture.date <= today);
                    break;
                case 'last_3_months':
                    filtered = filtered.filter(facture => facture.date >= last_3_months && facture.date <= today);
                    break;
                case 'last_6_months':
                    filtered = filtered.filter(facture => facture.date >= last_6_months && facture.date <= today);
                    break;
                case 'last_year':
                    filtered = filtered.filter(facture => facture.date >= last_year && facture.date <= today);
                    break;
            }
        }

        //sort by total
        if(this.search.total != ''){
            if(this.search.total == 'asc'){
                filtered = filtered.sort((a,b) => a.total - b.total);
            }else{
                filtered = filtered.sort((a,b) => b.total - a.total);
            }
        }

        //sort by due
        if(this.search.due != ''){
            if(this.search.due == 'asc'){
                filtered = filtered.sort((a,b) => a.due - b.due);
            }else{
                filtered = filtered.sort((a,b) => b.due - a.due);
            }
        }

        return filtered;                
    }
},
methods:{
    //pagination
    changePage(page){
         this.pagination.current_page = page;
        },
    changePageAjout(page){
        this.lineItemsPagination.currentPage=page;
        },
    //sort
    sortByTotal(){
        this.search.total = this.search.total === 'asc' ? 'desc' : 'asc';
    },
    sortByDue(){
        this.search.due = this.search.due === 'asc' ? 'desc' : 'asc';
    },
    //facture
    loadFactures(){
        axios.get(`/api/facture/direct/${this.store_id}`)
        .then(response => {
            this.factures = response.data;
            this.isLoading = false;
            console.log(this.factures);
        })
        .catch(error => {
            console.log(error);
        });
    },
    loadClients() {
        axios.get(`/api/customer/${this.store_id}`)
            .then(response => {
                console.log(response.data);
                response.data.forEach(client => {
                    this.clients.push({
                        id: client.id,
                        first_name: client.billing.first_name,
                        last_name: client.billing.last_name,
                        email: client.email,
                        phone: client.billing.phone,
                        adress: client.billing.address_1,
                    });
                });
            })
            .catch(error => {
                console.log(error);
            })
    },
    loadProducts() {
        axios.get(`/api/product/${this.store_id}`)
            .then(response => {
                console.log(response.data);
                response.data.forEach(product => {
                    if(product.stock_status == 'instock' && product.stock_quantity > 0 && product.status == 'publish') {
                        this.products.push({
                            id: product.id,
                            name: product.name,
                            price: product.price,
                            quantity: product.available_quantity,
                            sku: product.sku,
                        });
                    }
                });
            })
            .catch(error => {
                console.log(error);
            })
    },
    downloadPDF(facture) {
        axios.get(`/api/facture/direct/download/${facture.id}`, {responseType: 'blob'})
        .then(response => {
        // Obtenir le nom du fichier à partir des en-têtes de la réponse
        const contentDisposition = response.headers['content-disposition'];
        const filenameMatch = contentDisposition.match(/filename="(.+)"/);

        let filename = 'facture.pdf'; // Valeur par défaut en cas de problème avec l'extraction du nom

        if (filenameMatch && filenameMatch[1]) {
            filename = filenameMatch[1];
        }
        // Créer un blob à partir des données de la réponse
        const blob = new Blob([response.data], { type: 'application/pdf' });

        // Créer un lien pour le téléchargement du blob
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.target = '_blank';
        link.download = 'factureCommande.pdf'; 

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        window.URL.revokeObjectURL(link.href);
        })
        .catch(error => {
            console.log(error);
        });
        
  },
  sendEmail(facture){
        this.$Progress.start();
        axios.post(`/api/facture/sendMail/${facture.id}`,{email: 'yassinejrayfy35@gmail.com'}) //rmail: facture.email
        .then(response => {
            console.log(response.data);
            this.$Progress.finish();
            Swal.fire({
                icon: 'success',
                title: 'Email envoyé avec succès',
                showConfirmButton: false,
                timer: 1500
            });
        })
        .catch(error => {
            console.log(error);
            this.$Progress.fail();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Quelque chose n'a pas fonctionné!",
            });
        });
  },
  getFacturePayements(facture){
      // get payment history
      axios.get(`/api/payement/${facture.id}`)
      .then(response => {
          this.payements = response.data;
          // show modal
          $('#paymentHistoryModal').modal('show');
      })
      .catch(error => {
          console.log(error);
      });
  },
  viewPaymentHistory(facture){
        //facture edited
        this.factureEditee = facture;
        // get payment history
        this.getFacturePayements(facture);
   },
   addPayment(){
        this.$Progress.start();
        //if payementAmount + due > total => error
        console.log(this.payementAmount  , this.factureEditee.due);
        if(this.payementAmount > this.factureEditee.due){
            this.$Progress.fail();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Le montant du paiement est supérieur au montant dû!',
            });
            return;
        }
        // add payment
        const data = {
            facture: this.factureEditee.id,
            montant: this.payementAmount,
        };
        axios.post(`/api/payement`,data)
        .then(response => {
            // get payment history
            this.getFacturePayements(this.factureEditee);
            // update facture editee
            this.factureEditee.due = this.factureEditee.due - this.payementAmount;
            if(this.factureEditee.due == 0)
                this.factureEditee.payment_status = 'paye';
            // reset payment amount
            this.payementAmount = 0;
            //finish progress bar
            this.$Progress.finish();
        })
        .catch(error => {
            console.log(error);
            this.$Progress.fail();
        });
   },
   deletePayment(payement){
        this.$Progress.start();
        axios.delete(`/api/payement/${payement.id}`)
        .then(response => {
            // get payment history
            this.getFacturePayements(this.factureEditee);
            // update facture editee
            this.factureEditee.due = this.factureEditee.due + payement.amount;
            if(this.factureEditee.due > 0 )
                this.factureEditee.payment_status = 'incomplet';

            //finish progress bar
            this.$Progress.finish();
        })
        .catch(error => {
            console.log(error);
            this.$Progress.fail();
        });
   },
   showAddFactureModal(){
        $('#addFactureModal').modal('show');
   },
   resetForm(){
        this.facture = {
            client: '',
            email: '',
            telephone: '',
            adresse: '',
            products: [],
            total: 0,
            due: 0,
        };
        $('#addFactureModal').modal('hide');
   },
   fermerFacture(facture){
        this.$Progress.start();
        axios.put(`/api/facture/${facture.id}`, {status: 'ferme',store:this.store_id})
        .then(response => {
            //finish progress bar
            this.$Progress.finish();
            this.loadFactures();
        })
        .catch(error => {
            console.log(error);
            this.$Progress.fail();
        });
   },
   ouvrirFacture(facture){
        this.$Progress.start();
        axios.put(`/api/facture/${facture.id}`, {status: 'ouvert',store:this.store_id})
        .then(response => {
            //finish progress bar
            this.$Progress.finish();
            this.loadFactures();
        })
        .catch(error => {
            console.log(error);
            this.$Progress.fail();
        });
   },
   createFacture(){
    const client = this.clients.find(client => client.id == this.facture.client);
    const data = {
        client: client.first_name + ' ' + client.last_name,
        email:this.facture.email,
        telephone:this.facture.telephone,
        adresse:this.facture.adresse,
        ville:'Casablanca',
        pays:'MA',
        status:'completed',
        total:this.facture.total,
        line_items:this.facture.products,
        store:this.store_id,
        type:'dr',
    };

    //axios request
    this.$Progress.start();
    axios.post(`/api/facture/direct`, data)
    .then(response => {
        //finish progress bar
        this.$Progress.finish();
        //reset form
        this.resetForm();
        //close modal
        $('#addFactureModal').modal('hide');
        //show success message
        Swal.fire(
            'Success!',
            'Facture ajoutée avec succès',
            'success'
        );
        //reload factures
        this.loadFactures();
    });

   },
   deleteProduct(product){
        let index = this.facture.products.indexOf(product);
        this.facture.products.splice(index, 1);
        this.facture.total -= product.price * product.quantity;
    },
    addProduct(){
        // check if product is already added
        if(this.product.id == '' || this.quantityClass != '' || this.product.quantity <= 0){
            let message ='';
            if(this.product.id == ''){
                message += 'Veuillez choisir un produit';
            }
            if(this.quantityClass != ''){
                message += 'Veuillez saisir une quantité valide';
            }
            if(this.product.quantity <= 0){
                message += 'Veuillez saisir une quantité valide';
            }

            Swal.fire(
                'Error!',
                message,
                'error'
            );
            return;
        }

        let pdt = Object.assign({}, this.product);
        this.factureProducts= this.facture.products.push(pdt);
        console.log(this.factureProducts);
        this.facture.total += pdt.price * pdt.quantity;
        //this.product = {};
        /*if(this.validationErrors.products != '')
            this.validationErrors.products = '';*/
        
    },    
},
    
}
</script>

<style scoped>
/* Add more styles as needed */
.is-invalid {
    color:red;
}
/* Payment history modal styles */
.payment-history {
  margin-bottom: 20px;
  max-height: 270px !important;
}

.payment-history-item {
  padding: 10px;
  margin-bottom: 10px;
  border-left: 4px solid #007bff;
}

.payment-history-item-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 5px;
}

.payment-history-item-date {
  font-size: 16px;
  color: #007bff;
  margin: 0;
}

.payment-history-item-details {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.payment-history-item-amount {
  font-size: 16px;
  margin: 0;
}

.payment-summary {
  margin-top: 20px;
}

.payment-summary-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 5px;
}

.payment-summary-label {
  font-weight: bold;
  font-size: 16px;
}

.payment-summary-value {
  font-size: 16px;
}

.btn-add-payment {
    background-color: #f8f9fa;
    color: #007bff;
    border-color: #007bff;
}
.payment-summary-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.payment-summary-label {
  font-weight: bold;
  font-size: 16px;
  color: #555;
}

.payment-summary-value {
  font-size: 18px;
  color: #007bff;
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

/* Modifier la taille de police pour les liens de pagination */
.pagination .page-link {
  font-size: 12px; 
}
/* Modifier la taille de police pour les boutons */
.btn {
  font-size: 14px; 
}
.search-select{
  font-size: 13px; 
}
</style>