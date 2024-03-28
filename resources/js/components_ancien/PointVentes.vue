<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header" style="background-color: #2f4fb1; display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
                        <h3 class="card-title text-white">Point de vente</h3>
                        <div class="card-tools">
                            <button class="btn btn-light" @click="showAddModal()"  style="color: #01356F;">
                                Nouveau <i class="ti ti-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <div class="row mt-3  mx-2">
                        <div class="col-8 mt-2 justify-content-center col-md-3">
                            <input type="text" class="form-control" style="font-size: 13px" placeholder="Nom client" v-model="search.client" />
                        </div>
                        <!-- ville-->
                        <div class="col-8 mt-2 justify-content-center col-md-3">
                            <input type="text" class="form-control" style="font-size: 13px" placeholder="ville" v-model="search.ville" />
                        </div>
                        <!-- type_echange_commercial-->
                        <div class="col-8 mt-2 col-md-3">
                            <select class="form-select" style="font-size: 13px" v-model="search.type_echange_commercial">
                            <option value="">Type d'echange commercial</option>
                            <option v-for="type_echange_commercial in typeList" :key="type_echange_commercial" :value="type_echange_commercial">{{ type_echange_commercial }}</option>
                            </select>
                        </div>
                        <!-- type payement-->
                        <div class="col-8 mt-2 justify-content-center col-md-3">
                            <input type="text" class="form-control" style="font-size: 13px" placeholder="Type de paiement" v-model="search.type_payement" />
                        </div>
                        </div>
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <th>Commande ID</th>
                                <th>Client</th>
                                <th>telephone</th>
                                <th>Ville</th>
                                <th>Type de paiement</th>
                                <th>Type d'echanges commerciaux</th>
                                <th>Actions</th> 
                            </thead>
                            <tbody>
                                <tr v-for="pointVente in paginatedPointVentes" :key="pointVente.id">
                                    <td>{{ pointVente.order_id }}</td>
                                    <td >{{ pointVente.client }}</td>
                                    <td>{{ pointVente.telephone}}</td>
                                    <td>{{ pointVente.ville }}</td>
                                    <td>{{ pointVente.type_payement }}</td>
                                    <td>{{ pointVente.type_echange_commercial }}</td>
                                    <td>
                                        <button @click="editPointVente(pointVente)" class="btn btn-info">
                                          <i class="ti ti-edit"></i>
                                        </button>

                                        <button class="btn btn-danger" @click="deletePointVente(pointVente.id)">
                                          <i class="ti ti-trash-x"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>   
                    <div class="card-footer d-flex justify-content-center">
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

        <!-- Point de vente Modal -->
        <div class="modal fade" id="pointVenteModal" tabindex="-1" role="dialog" aria-labelledby="pointVenteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pointVenteModalLabel">Liste des clients</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Commande ID</th>
                                    <th>Client</th>
                                    <th>Ville</th>
                                    <th>Actions</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="order in orders" :key="order.id">
                                    <td>{{ order.id }}</td>
                                    <td>{{ order.billing['last_name'] }} {{ order.billing['first_name'] }}</td>
                                    <td>{{ order.billing['state'] }}</td>
                                    <td>
                                        <button @click="addPointVente(order)" class="btn btn-primary" v-if="!isExiste(order)">
                                          <i class="ti ti-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

         <!-- Modal pour modifier le point de vente-->
      <div v-if="pointVenteToModify" class="modal fade" id="modifierpointVenteModal" tabindex="-1" role="dialog" aria-labelledby="modifierpointVenteModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modifierpointVenteModalLabel">Modification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModifierpointVenteModal()">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="col-md-12">
                 <label for="type_payement">Type de paiement</label>
                 <input type="text" class="form-control" id="name" placeholder="Enter le type de payement" v-model="type_payement">       
              </div>
              <div class="col-md-12">
                <select class="form-select" v-model="pointVenteToModify.type_echange_commercial">
                  <option value="">Selectionner un type d'echanges commercial</option>
                  <option v-for="types in typeList" :key="types" :value="types">{{ types }}</option>
                </select>
                <span class="text-danger" v-if="pointVenteToModify.type_echange_commercial === ''">Veuillez sélectionner un type</span>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="updatePointVente()" :disabled="pointVenteToModify.type_echange_commercial === ''">Modifier</button>
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
        pointVentes: [],
        orders: [],
        boutiques: [],
        boutique: '',
        store_id: '',
        type_echange_commercial:'',
        typeList: [ 'B2B','B2C'],
        pointVenteToModify: null,
        total_commande: '',
        type_payement: '',
        search:{
        client: '',
        type_payement: '',
        type_echange_commercial: '',
        ville: '',
        },
        //pagination
        pagination:{
            current_page:1,
            per_page:5,
            total_pages:0,
         },
      }
  },
  computed: {
    paginatedPointVentes(){
        this.pagination.total_pages = Math.ceil(this.filteredPointVentes.length / this.pagination.per_page);
        return this.filteredPointVentes.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
     },
  filteredPointVentes() {
    let filteredPointVentes = Object.values(this.pointVentes);
    if (this.search.client && this.search.client !== '') {
        filteredPointVentes = filteredPointVentes.filter((pointVente) => {
        return pointVente.client.toLowerCase().startsWith(this.search.client.toLowerCase());
      });
    }
    if (this.search.type_echange_commercial && this.search.type_echange_commercial !== '') {
        filteredPointVentes = filteredPointVentes.filter((pointVente) => {
        return pointVente.type_echange_commercial.toLowerCase().includes(this.search.type_echange_commercial.toLowerCase());
      });
    }

    if (this.search.ville && this.search.ville !== '') {
        filteredPointVentes = filteredPointVentes.filter((pointVente) => {
        return pointVente.ville.toLowerCase().startsWith(this.search.ville.toLowerCase());
      });
    }

    if (this.search.type_payement && this.search.type_payement !== '') {
        filteredPointVentes = filteredPointVentes.filter((pointVente) => {
        return pointVente.type_payement.toLowerCase().startsWith(this.search.type_payement.toLowerCase());
      });
    }


    return filteredPointVentes;  

  },
  paginatedLinesItems(){
    if(this.orderDetails == null) return;

    this.lineItemsPagination.totalPages = Math.ceil(this.orderDetails.line_items.length / this.lineItemsPagination.perPage) ;
    const index = (this.lineItemsPagination.currentPage - 1) * this.lineItemsPagination.perPage;
    return this.orderDetails.line_items.slice(index, index + this.lineItemsPagination.perPage);
  }
},
  created(){
    // get store from current boutique
    if(this.$store.getters.currentBoutique)
      this.store_id = this.$store.getters.currentBoutique.id;
    this.loadCustomers();
  },
 
  methods:{
     //pagination
     changePage(page){
         this.pagination.current_page = page;
        },
      loadCustomers(){
          axios.get(`api/pointVente/${this.store_id}`)
          .then(({data}) => {
            (this.pointVentes = data.pointVentes);
            (this.boutique = data.boutique);
            (this.orders = data.customers);

            })
          .catch(({response}) => console.log(response.data));
      },
      showAddModal(){
        $('#pointVenteModal').modal('show');
      },
      addPointVente(order) {
        this.type_echange_commercial='B2C'
        const data = {
            client: order.billing['last_name'] + ' ' + order.billing['first_name'],
            telephone: order.billing['phone'],
            ville: order.billing['state'],
            type_payement:order.payment_method_title,
            order_id: order.id,
            boutique_id: this.store_id,
            customer_id: order.customer_id,
            type_echange_commercial: this.type_echange_commercial,
            // autres champs nécessaires
        };

        this.$Progress.start();
        axios.post('/api/pointVente', data)
        .then((response) => {
        console.log(response.data);
        this.loadCustomers();
        this.$Progress.finish();
        Swal.fire(
        'Bon travail!',
        'Point de vente ajouté avec succès!',
        'success'
        );
        $('#pointVenteModal').modal('hide');
        })
        .catch((error) =>{
        this.$Progress.fail();
        console.log(error);
        });
    },
    isExiste(order) {
        return this.pointVentes.some((point_vente) => point_vente.order_id === order.id &&  point_vente.customer_id === order.customer_id);
        },
        editPointVente(pointVente) {
            this.pointVenteToModify = Object.assign({}, pointVente);
            this.type_payement= this.pointVenteToModify.type_payement;
            this.$nextTick(() => {
            $('#modifierpointVenteModal').modal('show');
            }); 
            },
        closeModifierpointVenteModal() {
            this.pointVenteToModify = null;
            $('#modifierpointVenteModal').modal('hide');
        },
        updatePointVente() {
            // progress bar
            const data = {
                type_payement: this.type_payement,
                type_echange_commercial: this.pointVenteToModify.type_echange_commercial,
                boutique_id: this.store_id,
            }
            this.$Progress.start();
            axios.put(`api/pointVente/${this.pointVenteToModify.id}`, data)
            .then((response) => {
                console.log(response.data);
                //swal success
                Swal.fire({
                icon: 'success',
                title: 'Point de vente mis à jour avec succès',
                })
                // progress bar
                this.loadCustomers();
                this.$Progress.finish();
                this.closeModifierpointVenteModal();
            })
            .catch((error) => {
                console.log('fetch error',error);
            });
        }, 
        deletePointVente(id){
                                //Swal confirm
                Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Vous ne pourrez pas revenir en arrière!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor:'#3085d6',
                cancelButtonColor:'#d33',
                confirmButtonText:'Oui, supprimez-le!',
                cancelButtonText: 'Annuler',
                }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/pointVente/${id}`)
                    .then(() => {
                    this.loadCustomers();
                    Swal.fire(
                        'Supprimé!',
                        'Le point de vente a été supprimé.',
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
<style>
.icon-space {
    margin-left: 10px; /* Ajustez la valeur selon vos besoins */
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
.spinner-container {
    position: fixed;
    top: 43%; /* Ajustez cette valeur pour centrer verticalement */
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999; /* Assurez-vous que le spinner est au-dessus de tout le reste */
    background-color: rgba(255, 255, 255, 0.7); /* Un arrière-plan semi-transparent pour le contraste */
}
</style>