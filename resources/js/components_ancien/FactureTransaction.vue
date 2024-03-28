<template>
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="background-color: #2f4fb1; display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
                <h3 class="card-title text-white">Factures par Boutique Transactions</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <!-- Recherche -->
                <div class="row m-3 ">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Rechercher par fournisseur" v-model="search.name">
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
                            <option value="">Selectionner le statut de paiement</option>
                            <option value="paye">Payé</option>
                            <option value="incomplet">Incomplet</option>
                        </select>
                    </div>
                    <!-- date (3 derniers jours, semaine dernière ...)-->
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
                        <th>Fournisseur</th>
                        <th>
                            Total
                        </th>
                        <th>
                            Montant dû 
                            <a @click="sortByDue">
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
                        <tr  v-if="!isLoading" v-for="facture in paginatedFactureTransaction" :key="facture.id">
                            <td>{{facture.id}}</td>
                            <td>{{facture.fournisseur}}</td>
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
                                <!-- Voir les trace de paiement -->
                                <button class="btn btn-sm btn-secondary" @click="viewPaymentHistory(facture)">
                                    <i class="fas fa-money-bill"></i>
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
            <div  v-if="!isLoading" class="card-footer d-flex justify-content-center">
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
    
    <!--Modale de suivi des paiements-->
    <div class="modal fade" id="paymentHistoryModal" tabindex="-1" aria-labelledby="paymentHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentHistoryModalLabel">Historique des paiements</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
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
</div>
</template>

<script>
import Swal from 'sweetalert2';

export default {
    data: () => ({
    store_id:null,
    factures: [],
    payements: {
        history: [],
        total: 0,
        due: 0,
    },
    factureEditee: {},
    payementAmount: 0,
    search: {
        name: '',
        status: '',
        payment_status: '',
        date: '',
        total: 'asc',
        due: 'asc',
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
    console.log('Composant monté.');    // obtenir la boutique actuelle
    if(this.$store.getters.currentBoutique)
        this.store_id = this.$store.getters.currentBoutique.id;
    
    console.log(this.store_id);  
    this.loadFactures();
},
computed:{
    paginatedFactureTransaction(){
        this.pagination.total_pages = Math.ceil(this.filteredFactures.length / this.pagination.per_page);
        return this.filteredFactures.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
     },
    filteredFactures(){
        let filtered = Object.assign([], this.factures);
        //filtrer par nom
        if(this.search.name != ''){
            filtered = filtered.filter(facture => facture.fournisseur.toLowerCase().includes(this.search.name.toLowerCase()));
        }
        //filtrer par status
        if(this.search.status != ''){
            filtered = filtered.filter(facture => facture.status == this.search.status);
        }
        //filtrer par statut de paiement
        if(this.search.payment_status != ''){
                    filtered = filtered.filter(facture => {
                        return facture.payment_status == this.search.payment_status;
                    })
                }
        //filtrer par date
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

        //trier par total
        if(this.search.total != ''){
            if(this.search.total == 'asc'){
                filtered = filtered.sort((a,b) => a.total - b.total);
            }else{
                filtered = filtered.sort((a,b) => b.total - a.total);
            }
        }

        //trier par due
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
    //sort
    sortByToal(){
        this.search.total = this.search.total === 'asc' ? 'desc' : 'asc';
    },
    sortByDue(){
        this.search.due = this.search.due === 'asc' ? 'desc' : 'asc';
    },
    //facture
    loadFactures(){
        axios.get(`/api/facture/transaction/${this.store_id}`)
        .then(response => {
            this.factures = response.data;
            this.isLoading = false;
            console.log(this.factures);
        })
        .catch(error => {
            console.log(error);
        });
    },
//     downloadPDF(facture) {
//         axios.get(`/api/facture/transaction/download/${facture.id}`, {responseType: 'blob'})
//         .then(response => response.blob())
//         .then(blob => {
//             // Créer un lien blob pour le téléchargement
//             const link = document.createElement('a');
//             link.href = window.URL.createObjectURL(blob);
//             link.target = '_blank';
//             link.download = facture.pdf; 

//             document.body.appendChild(link);
//             link.click();
//             document.body.removeChild(link);
//             window.URL.revokeObjectURL(link.href);
//         })
//         .catch(error => {
//             console.log(error);
//         });
        
//   },
downloadPDF(facture) {
    axios.get(`/api/facture/transaction/download/${facture.id}`, { responseType: 'arraybuffer' }) 
    .then(response => {
        // Créer un blob à partir des données de la réponse
        const blob = new Blob([response.data], { type: 'application/pdf' });

        // Créer un lien pour le téléchargement du blob
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.target = '_blank';
        // link.download = facture.pdf; 
        link.download = 'factureTransaction.pdf';

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
      axios.get(`/api/payement/${facture.id}`)
      .then(response => {
          this.payements = response.data;
      })
      .catch(error => {
          console.log(error);
      });
  },
  viewPaymentHistory(facture){
        this.factureEditee = facture;
        this.getFacturePayements(facture);
        $('#paymentHistoryModal').modal('show');
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
        // Ajouter le paiement
        const data = {
            facture: this.factureEditee.id,
            montant: this.payementAmount,
        };
        axios.post(`/api/payement`,data)
        .then(response => {
            this.getFacturePayements(this.factureEditee);
            this.factureEditee.due = this.factureEditee.due - this.payementAmount;
            if(this.factureEditee.due == 0)
                this.factureEditee.payment_status = 'paye';
            this.payementAmount = 0;
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
            // obtenir l'historique des paiements
            this.getFacturePayements(this.factureEditee);
            // mise à jour facture editee
            this.factureEditee.due = this.factureEditee.due + payement.amount;
            if(this.factureEditee.due > 0 )
                this.factureEditee.payment_status = 'incomplet';
            //barre de progression de la finition
            this.$Progress.finish();
        })
        .catch(error => {
            console.log(error);
            this.$Progress.fail();
        });
   },
   fermerFacture(facture){
        this.$Progress.start();
        axios.put(`/api/facture/${facture.id}`, {status: 'ferme',store:this.store_id})
        .then(response => {
            //barre de progression de la finition
            this.$Progress.finish();
            //recharger les factures
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
            //barre de progression de la finition
            this.$Progress.finish();
            //recharger les factures
            this.loadFactures();
        })
        .catch(error => {
            console.log(error);
            this.$Progress.fail();
        });
   },  
},
    
}
</script>

<style scoped>
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
  font-size: 13px; 
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