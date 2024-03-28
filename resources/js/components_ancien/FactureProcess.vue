<template>
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="background-color: #2f4fb1; display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
            <h3 class="card-title text-white">Factures par Boutique process</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <!-- search -->
                <div class="row m-3 ">
                    <div class="col-8 mt-2 col-md-3">
                        <input type="text" class="form-control search-select" placeholder="Rechercher par client" v-model="search.name">
                    </div>
                    <!-- date (last 3days , last week ...)-->
                    <div class="col-8 mt-2 col-md-3">
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
                            Total <a @click="sortByTotal"><i class="fas fa-sort"></i></a>
                        </th>
                        <th>Montant dû</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Statut du paiement</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <tr v-if="!isLoading" v-for="facture in paginatedFactureProcess" :key="facture.id">
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
                                <span class="badge badge-warning" v-else-if="facture.payment_status == 'incomplet'">
                                    Incomplet
                                </span>
                            </td>
                            <td>
                                <!-- view payment history -->
                                <button class="btn btn-sm btn-secondary" @click="viewPaymentHistory(facture)">
                                    <i class="fas fa-eye"></i>
                                    Trace de paiement
                                </button>
                                <!-- export pdf -->
                                <button class="btn btn-sm btn-success" @click="downloadPDF(facture)">
                                    <i class="fas fa-file-pdf"></i>
                                    Exporter PDF
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="payment-history">
                        <div class="payment-history-item" v-for="payement in payements.history" :key="payement.id">
                            <div class="payment-history-item-header">
                                <p class="payment-history-item-date">{{ payement.date | myDate }}</p>
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
</div>
</template>

<script>
export default {
    data: () => ({
    store_id:null,
    factures: [],
    payements: {
        history: [],
        total: 0,
        due: 0,
    },
    search: {
        name: '',
        date: '',
        total: 'asc',
    },
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
computed : {
    paginatedFactureProcess(){
        this.pagination.total_pages = Math.ceil(this.filteredFactures.length / this.pagination.per_page);
        return this.filteredFactures.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
     },
    filteredFactures(){
        let filtered = Object.assign([], this.factures);
        //filter by name
        if(this.search.name != ''){
            filtered = filtered.filter(facture => facture.client.toLowerCase().includes(this.search.name.toLowerCase()));
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


        return filtered;                
    }
},
methods:{
    //pagination
    changePage(page){
         this.pagination.current_page = page;
        },
    //sort
    sortByTotal(){
        this.search.total = this.search.total === 'asc' ? 'desc' : 'asc';
    },
    //
    loadFactures(){
        axios.get(`/api/facture/process/${this.store_id}`)
        .then(response => {
            this.factures = response.data;
            this.isLoading = false;
            console.log(this.factures);
        })
        .catch(error => {
            console.log(error);
        });
    },
    downloadPDF(facture) {
        axios.get(`/api/facture/process/download/${facture.id}`, {responseType: 'blob'})
        .then(response => {
        // Créer un blob à partir des données de la réponse
        const blob = new Blob([response.data], { type: 'application/pdf' });

        // Créer un lien pour le téléchargement du blob
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.target = '_blank';
        // link.download = facture.pdf; 
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
  getFacturePayements(facture){
      // get payment history
      axios.get(`/api/payement/${facture.id}`)
      .then(response => {
          this.payements = response.data;
      })
      .catch(error => {
          console.log(error);
      });
  },
  viewPaymentHistory(facture){
        // get payment history
        this.getFacturePayements(facture);
        // show modal
        $('#paymentHistoryModal').modal('show');
   },
},
    
}
</script>

<style scoped>
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
.search-select{
  font-size: 13px; 
}
</style>