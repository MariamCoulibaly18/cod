<template>
  <div class="container">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" style="background-color: #2f4fb1; display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
          <h3 class="card-title text-white" style="font-size: 20px;">Vos Commandes Assignées</h3>
        </div>
        
        <div class="card-body table-responsive p-0">
          <div class="row m-3">
            <div class="col-8 mt-2 justify-content-center col-md-3">
               <input type="text" class="form-control" style="font-size: 13px; " placeholder="Nom du client" v-model="search.client">
             </div>
             <div class="col-8 mt-2 col-md-3 ">
                <select class="form-select search-select"  v-model="search.status">
                  <option value="">Sélectionner un status</option>
                  <option v-for="status in statusList" :key="status" :value="status">{{ status }}</option>
                </select>
              </div>
          </div>
          <table>
            <thead>
              <tr style="font-size: 16px;">
                <th>ID Commande</th>
                <th>Client</th>
                <th>Statut</th>
                <th>
                  Total
                  <button class="btn btn-link btn-sm" @click="sortByTotal()">
                    <i class="fas fa-sort fa-fw"></i>
                  </button>
                </th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody style="font-size: 14px;">
              <tr v-for="commande in paginatedCommandes" :key="commande.id">
                <td>{{ commande.id }}</td>
                <td>{{ commande.client.last_name }} {{ commande.client.first_name }}</td>
                <td>{{ commande.status }}</td>
                <td>{{ commande.total }}</td>
                <td>
                  <!-- detail-->
                  <button class="btn btn-success" @click="showOrderDetails(commande)">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <button class="btn btn-primary" @click="AccepterCommande(commande)" v-if="isAccepted(commande.id)==0">
                    <i>Accepter</i>
                  </button>
                  <button class="btn btn-danger" @click="RefuserCommande(commande)" v-if="isAccepted(commande.id)==0">
                    <i>Refuser</i>
                  </button >
                  <button  class="btn" v-if="isAccepted(commande.id)==1">
                    <div @click="showStatutDropdown(commande)"
                              :class="{
                                'status-grey': commande.statut_livraison.status === 'Pas commencer',
                                'status-red':  commande.statut_livraison.status === 'Perdu',
                                'status-green':  commande.statut_livraison.status === 'Livrer',
                                'status-yellow': commande.statut_livraison.status !== 'Pas commencer' && commande.statut_livraison.status !== 'Perdu' 
                                  && commande.statut_livraison.status !== 'Livrer' }"
                              style="display: inline-block; border: 1px solid; padding: 5px; cursor: pointer;">
                              {{ commande.statut_livraison.status }}
                       </div>
                    <div v-if="selectedOrderId === commande.id">
                      <select v-model="commande.statut_livraison.id" @change="updateStatutLivraison(commande)">
                        <option v-for="statutLivraison in statutLivraisons" :value="statutLivraison.id" :key="statutLivraison.id">
                          {{ statutLivraison.status }}
                        </option>
                      </select>
                    </div>
                  </button>   
                  <button  class="btn" v-if="isAccepted(commande.id) === null">
                   Refuser
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

      <!-- detail modal-->
      <div v-if="orderDetails" class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" style="font-size: 11px;" id="orderDetailsModalLabel">Order Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeDetailsModal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                      <div class="col-md-6">
                        <h5 class="mb-3">Client Information:</h5>
                        <p><strong>Name:</strong> {{ orderDetails.client.last_name }} {{ orderDetails.client.first_name }}</p>
                        <p><strong>Email:</strong> {{ orderDetails.client.email }}</p>
                        <p><strong>Phone:</strong> {{ orderDetails.client.phone }}</p>
                        <p><strong>Address:</strong> {{ orderDetails.client.adress }}</p>
                      </div>
                      <div class="col-md-6">
                        <h5 class="mb-3">Order Information:</h5>
                        <p><strong>Status:</strong> {{ orderDetails.status }}</p>
                        <p><strong>Total:</strong> {{ orderDetails.total | prix }}</p>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-12">
                        <h5 class="mb-3">Products:</h5>
                        <table class="table table-striped">
                          <thead class="thead-dark">
                            <tr>
                              <th scope="col">Product</th>
                              <th scope="col">Quantity</th>
                              <th scope="col">Price</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(product, productIndex) in orderDetails.products" :key="productIndex">
                              <td>{{ product.name }}</td>
                              <td>{{ product.quantity }}</td>
                              <td>{{ product.price | prix }}</td>
                            </tr>
                          </tbody>
                          <tfoot class="bg-info">
                            <tr>
                              <td colspan="3" class="text-right"><strong>Total Cost:</strong></td>
                              <td colspan="2">{{ orderDetails.total | prix }}</td>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeDetailsModal">Close</button>
            </div>
          </div>
        </div>
      </div>

  </div>
</template>
<script>
import axios from 'axios';
import Swal from 'sweetalert2';
      export default {
          data: () => ({
         
           commandes:[],
           orderDetails:null,
           livreurCommande:[],
           livreurCommande2:[],
           accepted:0,
           boutonaccepted:false,
           status: '',
           statutLivraison: '',
           statusList: [ 'pending','processing','on-hold','completed','cancelled','refunded',],
           boutique:[],
           store_id:'',
           statutLivraisons: [],
           selectedOrderId: null,
           selectedStatusId: null,
           search : {
            client:'',
            status:'',
           },
          //pagination
          pagination:{
                current_page:1,
                per_page:5,
                total_pages:0,
              },
           
    }),
    computed : {
      paginatedCommandes(){
          this.pagination.total_pages = Math.ceil(this.filteredCommandes.length / this.pagination.per_page);
          return this.filteredCommandes.slice((this.pagination.current_page - 1) * this.pagination.per_page, this.pagination.current_page * this.pagination.per_page);
      },
      filteredCommandes(){
        let filtered = this.commandes;
        if (this.search.client && this.search.client !== '') {
          filtered = filtered.filter((order) => {
            return order.client.last_name.toLowerCase().startsWith(this.search.client.toLowerCase()) || order.client.first_name.toLowerCase().startsWith(this.search.client.toLowerCase());
          });
        }

        if (this.search.status && this.search.status !== '') {
          filtered = filtered.filter((order) => {
            return order.status.toLowerCase().includes(this.search.status.toLowerCase());
          });
        }
        return filtered;
      }
   },
    created(){
    this.loadcommandes();
    this.loadStatutLivraison(); 
  },
    methods:{
       //pagination
     changePage(page){
         this.pagination.current_page = page;
        },
        loadcommandes() {
          axios.get('/api/assignedOrders')
            .then((response) => {
              // ...
              this.livreurCommande= response.data.livreur_commande;
              this.boutique= response.data.boutique;
              this.commandes = response.data.commandes.map(commande => {
                const livreurCmd = this.livreurCommande.find(livCmd => livCmd.order_id === commande.id);
                if (livreurCmd) {
                  commande.statut_livraison = livreurCmd.statut_livraison;
                }
                return commande;
              });
              console.log(this.commandes);
              console.log(this.livreurCommande);
              // ...
            })
            .catch(({response}) => console.log(response.data));
        },

        showOrderDetails(commande) {
          this.orderDetails = commande;
          this.$nextTick(() => {
            $('#orderDetailsModal').modal('show');
          });
        },
        loadStatutLivraison(){
            axios.get('api/statutLivraison/')
            .then((response =>{
                console.log(response.data.statusLivraisons);
                this.statutLivraisons= response.data.statusLivraisons;
            }))
            .catch((error) => console.log(error));
        },

        showStatutDropdown(commande) {
          // Basculez la visibilité du menu déroulant pour la commande sélectionnée
          // this.selectedOrderId = this.selectedOrderId === commande.id ? null : commande.id;
          // Fermez la liste déroulante si elle est déjà ouverte pour cette commande
          if (this.selectedOrderId === commande.id) {
              this.selectedOrderId = null;
            } else {
              // Ouvrez la liste déroulante pour la commande sélectionnée
              this.selectedOrderId = commande.id;
            }
        },
        updateStatutLivraison(commande) {
          // progress bar
          const order=commande;
          this.status="completed";
          this.store_id= this.boutique.id;
          const data = {
            store: this.store_id,
            statut_livraison_id: order.statut_livraison.id,
          };
          if (order.statut_livraison.status === "livrer" || order.statut_livraison.status === "Livrer" )
          {
            const commandeData = {
            store: this.store_id,
            status: this.status,
            order_id: order.id,
          };
          axios.post('api/updateStatus', commandeData )
              .then((response) => {
                console.log(response.data);
                this.loadcommandes();
                // this.loadProducts();
              })
          }
          this.$Progress.start();
          console.log(data);
          axios.put(`api/updateLivraisonStatut/${order.id}`, data)
            .then((response) => {
              console.log(response.data);
              //update on the orders list
              //swal success
              Swal.fire({
                icon: 'success',
                title: 'Status de la commande mise à jour avec succès',
                showConfirmButton: false,
                timer: 1500
              })
              // progress bar
              this.$Progress.finish();
              this.loadcommandes();
                this.selectedOrderId = null;          
             })
            .catch((error) => {
              console.log('fetch error',error);
            });
        }, 
        closeDetailsModal() {
          this.orderDetails = null;
          $('#orderDetailsModal').modal('hide');
        },
        isAccepted(commandeId) {
          const livreurCmd = this.livreurCommande.find((livreurCmd) => livreurCmd.order_id === commandeId);
          return livreurCmd && livreurCmd.accepted;
        },
        AccepterCommande(commande){
          const order= commande;
          this.accepted=1;
          this.store_id= this.boutique.id;
          this.status='processing';
          const livreur_CommandeData={
            accepted: this.accepted,
          };
          const commandeData = {
            store: this.store_id,
            status: this.status,
            order_id: order.id,
          };
          console.log(this.store_id);
          this.$Progress.start();
          axios.put(`api/assignedOrders/${order.id}`,livreur_CommandeData)
          .then((response) => {
           this.livreurCommande2 = response.data.livreurCommande;
                  const notifData = {
                      livreur_id: this.livreurCommande2.livreur_id,
                      order_id: order.id,
                      accepted: this.accepted,
                  }

                  axios.post(`api/sendNotification/${this.store_id}`, notifData)
                      .then(response => {
                          console.log(response.data.message);
                      })

            this.$Progress.finish();
            axios.post('api/updateStatus', commandeData )
              .then((response) => {
                console.log(response.data);
                this.loadcommandes();
                // this.loadProducts();
              })
              const commandeD = {
                order_id: order.id,
                accepted: this.accepted,
              }
              console.log(this.store_id);
              axios.post(`api/sendMailAdmin/${this.store_id}`,commandeD)
              .then(response => {
                console.log(response.data.message);
              })
            Swal.fire(
            'Good job!',
            'Commande accepted successfully!',
            'success'
            );
          })
          .catch((error) => {
            this.$Progress.fail();
            if(error.response.status == 422){
              console.log(this.errors);
            }  
          });
        },
        RefuserCommande(commande) {
          const order = commande;
          this.accepted = -1;
          this.store_id = this.boutique.id;
          this.status = 'pending';
          const livreur_CommandeData = {
              accepted: this.accepted,
          };
          const commandeData = {
              store: this.store_id,
              status: this.status,
              order_id: order.id,
          }
          const commandeD = {
              order_id: order.id,
              accepted: this.accepted,
          }

          this.$Progress.start();
          axios.put(`api/assignedOrders/${order.id}`, livreur_CommandeData)
              .then((response) => {
                  this.livreurCommande2 = response.data.livreurCommande;
                  const notifData = {
                      livreur_id: this.livreurCommande2.livreur_id,
                      order_id: order.id,
                      accepted: this.accepted,
                  }

                  axios.post(`api/sendNotification/${this.store_id}`, notifData)
                      .then(response => {
                          console.log(response.data.message);
                      })

                  this.loadcommandes();
                  this.$Progress.finish();
                  axios.post('/api/updateStatus', commandeData)
                      .then((response) => {
                          console.log(response.data);
                          this.loadcommandes();
                      })
                      console.log(this.store_id);
                      axios.post(`api/sendMailAdmin/${this.store_id}`, commandeD)
                      .then(response => {
                          console.log(response.data.message);
                      })
              })
              .catch((error) => {
                  this.$Progress.fail();
                  if (error.response.status == 422) {
                      console.log(this.errors);
                  }
              });
      }


    }
        
    }
    </script>
<style>

.status-yellow {
    background-color: rgb(226, 198, 169);
    display: inline-block; 
    border: 1px solid rgb(128, 98, 0); 
    color: rgb(128, 98, 0);
    padding: 2px;
    cursor: pointer;
    border-radius: 5px; 
    border-style: dashed;
    margin-top: 10px
}

.status-green {
    display: inline-block; 
    border: 1px solid green ; 
    color: green;
    background-color: rgb(220, 243, 220); 
    padding: 10px;
    border-radius: 5px; 
    border-style: dashed;
}
.status-red {
    display: inline-block; 
    border: 1px solid red; 
    color: red;
    background-color: rgb(241, 201, 195); 
    padding: 10px;
    border-radius: 5px; 
    border-style: dashed;
}

.status-grey {
    display: inline-block; 
    border: 1px solid grey ; 
    color: rgba(33, 28, 28, 0.465);
    background-color: #E7E8EA; 
    padding: 10px;
    border-radius: 5px; 
    border-style: dashed;
}
.card-title,
.btn,
.modal-title,
.table th,
.table td,
.table p,
.form-control,
.select,
.input-group {
    font-size: 11px; /* Vous pouvez ajuster cette valeur en fonction de vos préférences */
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