<template>
  <!-- Main content -->
  <div class="content" style="margin-bottom: 100px;">
    <!-- Tableau de bord principal -->
    <div v-if="$gate.isNull()">
        <!-- Animation d'entrée -->
       <transition name="fade">
        <div v-if="showWelcomeMessage" class="welcome-message">
          <h1 class="animated-text">Bonjour ,  {{ this.currentUser.name }}.</h1>
          <h2 style="font-size: 20px;">Bienvenue sur votre tableau de bord de COD</h2>
          <p class="role-pending">Votre rôle est en attente d'approbation par l'administrateur.</p>
        </div>
      </transition>
       <!-- Animation Canvas -->
       <!-- <canvas ref="canvas"></canvas> -->
      </div>
      <div class="container-fluid" v-if="$gate.isLivreur() ">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Tableau de bord</h1>
            </div>
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <div>
        <transition name="fade">
          <div v-if="showWelcomeMessage" class="welcome-message">
            <h1 class="animated-text">Bonjour ,  {{ this.currentUser.name }}.</h1>
            <h2 style="font-size: 20px;">Bienvenue sur votre tableau de bord de COD</h2>
          </div>
        </transition>
      </div>
      <!-- <div>
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0" style="background-color: #E5E6E7 !important;">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title" style="color: #01356F;">Ventes</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">2029DHs</span>
                    <span>Ventes au fil du temps</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span :class="{ 'text-success': this.pourcentageMensuel >= 0, 'text-danger': this.pourcentageMensuel < 0 }">
                    <i :class="{'fas fa-arrow-up': this.pourcentageMensuel >= 0,'fas fa-arrow-down': this.pourcentageMensuel < 0  }"></i> 
                    12%
                  </span>
                    <span class="text-muted">Par rapport au dernier mois</span>
                  </p>
                </div>
                <div class="position-relative mb-4">
                  <canvas id="livreur-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square" style="color: #002657;"></i> Cette année
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0" style="background-color: #E5E6E7 !important;">
                <h3 class="card-title" style="color: #01356F;">Aperçu de la boutique en ligne</h3>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                  <p class="d-flex flex-column text-left">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-up text-warning"></i>50 %
                    </span>
                    <span class="text-muted">TAUX DE CONVERSION</span>
                  </p>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-0">
                  <p class="d-flex flex-column text-left">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-down text-danger"></i> 12 %
                    </span>
                    <span class="text-muted">TAUX DE REMBOURSEMENT</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
    </div>
    <div class="container-fluid" v-if="$gate.isSuperAdmin() || $gate.isAdmin() ">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Tableau de bord</h1>
            </div>
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <div v-if="this.$store.getters.currentBoutique">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0" style="background-color: #E5E6E7 !important;">
                <div class="d-flex justify-content-between" >
                  <h3 class="card-title" style="color: #01356F;"> Nombres de commandes</h3>
                  <!-- <a href="javascript:void(0);">Voir le rapport</a> -->
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">{{ totalCommande }}</span>
                    <span>Commandes au fil du temps</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="visitors-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square" style="color: #002657;"></i> Cette année
                  </span>

                  <span>
                    <i class="fas fa-square" style="color: #CED4DA;"></i> L'année dernière
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header border-0" style="background-color: #E5E6E7 !important;">
                <h3 class="card-title" style="color: #01356F;">Produits les plus vendus</h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Ventes</th>
                    <th>Categories</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr  v-for="produit in produits" :key="produit.id">
                    <td>
                      {{ produit.name }}     
                   </td>
                    <td>{{ produit.price }} DHS</td>
                    <td>
                      <small class="text-success mr-1">
                        <i class="fas fa-arrow-up"></i>
                        {{ getPercentage(produit.count) }}%
                      </small>
                      {{ produit.count }} Achetés
                    </td>
                    <td>
                      <div class="d-flex flex-wrap w-100" >
                              <span v-for="(categorie, categorieIndex) in produit.categories" :key="categorieIndex" class="badge badge-secondary m-3">
                                {{ categorie.name }}
                              </span>
                        </div>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0" style="background-color: #E5E6E7 !important;">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title" style="color: #01356F;">Ventes</h3>
                  <!-- <a href="javascript:void(0);">Voir le rapport</a> -->
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">{{this.totalVentes}} DHs</span>
                    <span>Ventes au fil du temps</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span :class="{ 'text-success': this.pourcentageMensuel >= 0, 'text-danger': this.pourcentageMensuel < 0 }">
                    <i :class="{'fas fa-arrow-up': this.pourcentageMensuel >= 0,'fas fa-arrow-down': this.pourcentageMensuel < 0  }"></i> 
                    {{ this.pourcentageMensuel }}%
                  </span>
                    <span class="text-muted">Par rapport au dernier mois</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square" style="color: #002657;"></i> Cette année
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header border-0" style="background-color: #E5E6E7 !important;">
                <h3 class="card-title" style="color: #01356F;">Aperçu de la boutique en ligne</h3>
                <!-- <div class="card-tools">
                  <a href="#" class="btn btn-sm btn-tool">
                    <i class="fas fa-download"></i>
                  </a>
                  <a href="#" class="btn btn-sm btn-tool">
                    <i class="fas fa-bars"></i>
                  </a>
                </div> -->
              </div>
              <div class="card-body">
                <!-- /.d-flex -->
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                  <!-- <p class="text-warning text-xl">
                    <i class="ion ion-ios-cart-outline"></i>
                  </p> -->
                  <p class="d-flex flex-column text-left">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-up text-warning"></i>{{ this.tauxConversion }} %
                    </span>
                    <span class="text-muted">TAUX DE CONVERSION</span>
                  </p>
                </div>
                <!-- /.d-flex -->
                <div class="d-flex justify-content-between align-items-center mb-0">
                  <!-- <p class="text-danger text-xl">
                    <i class="ion ion-ios-people-outline"></i>
                  </p> -->
                  <p class="d-flex flex-column text-left">
                    <span class="font-weight-bold">
                      <i class="ion ion-android-arrow-down text-danger"></i> {{ this.tauxRemboursement }} %
                    </span>
                    <span class="text-muted">TAUX DE REMBOURSEMENT</span>
                  </p>
                </div>
                <!-- /.d-flex -->
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
      </div>
      <div v-else>
          <transition name="fade">
            <div v-if="showWelcomeMessage" class="welcome-message">
              <h3 class="animated-text">Bonjour, {{ this.currentUser.name }}</h3>
              <h5>Bienvenue sur votre tableau de bord de COD</h5>
              <p v-if="this.nombreBoutiques == 0">Vous ne gérez aucune boutique en ligne pour le moment. 
                Connecter vous sur une boutique pour voir ses détails.</p>
              <p v-if="this.nombreBoutiques == 1">Vous gérez actuellement {{this.nombreBoutiques}} boutique en ligne. 
                Connecter vous sur votre boutique pour voir ses détails.</p>
              <p v-if="this.nombreBoutiques > 1">Vous gérez actuellement {{this.nombreBoutiques}} boutiques en ligne. 
               Connecter vous sur une boutique pour voir ses détails.</p>
              <button @click="showDashboard" class="cta-button">Commencer</button>
            </div>
          </transition>
          <!-- Animation Canvas -->
          <!-- <canvas ref="canvas"></canvas> -->
         </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
 
</template>
<script>
export default {
    data() {
      return {
        nombreBoutiques: null,
        commandesParAnnee: [],
        commandesParAnneeDerniere: [],
        produits:[],
        totalCommande:0,
        ventesParMois:[],
        pourcentageMensuel:0,
        totalVentes:'',
        tauxConversion:0,
        tauxRemboursement:0,
        stores:[], 
        currentUser: '',  
        users:{}  , 
        store_id:'',
        show: false,
      showWelcomeMessage: true, // Ajoutez cette ligne      
      };
    },
    created(){
      if(this.$store.getters.currentBoutique){
      this.store_id = this.$store.getters.currentBoutique.id;
      this.loadProduits();
      this.loadCommandes();
      this.loadVentes();
      this.loadCalculTaux();
       }
      // currentUser
      this.currentUser = window.user;
      if(this.currentUser.type=='super_admin' || this.currentUser.type=='admin'){
        this.loadNombreBoutiques();
      }
    },
    methods:{
      showDashboard(){
      // this.show = true;
      this.$router.push('/boutiques');
    },
    loadNombreBoutiques(){
            axios.get('api/dashboard/nombreBoutiques')
            .then((response =>{
                console.log(response.data.nombreBoutiques);
                this.nombreBoutiques= response.data.nombreBoutiques;
            }))
            .catch((error) => console.log(error));
        },
    loadProduits(){
      console.log(this.store_id);
            axios.get(`api/dashboard/produitVendus/${this.store_id}`)
            .then((response =>{
                console.log(response.data.produits);
                this.produits= response.data.produits;
            }))
            .catch((error) => console.log(error));
        },
        getPercentage(count) {
          if (this.totalSales > 0) {
            return ((count / this.totalSales) * 100).toFixed(2);
          } else {
            return 0;
          }
        },
        loadCommandes(){
              axios.get(`api/dashboard/commandes/${this.store_id}`)
              .then((response =>{
                  this.commandesParAnnee= response.data.commandesParAnnee;
                  this.commandesParAnneeDerniere = response.data.commandesParAnneeDerniere;
                  this.totalCommande= response.data.nombreTotalDeCommandes;
                  this.createChart(); // Appelez la méthode createChart une fois que les données sont chargées

              }))
              .catch((error) => console.log(error));
          },
          loadVentes(){
              axios.get(`api/dashboard/ventes/${this.store_id}`)
              .then((response =>{
                  console.log(response.data.totalVentes);
                  this.totalVentes= response.data.totalVentes;
                  this.ventesParMois= response.data.ventesParMois;
                  this.pourcentageMensuel= response.data.pourcentageMensuel;
                  this.createChartSales(); // Appelez la méthode createChart une fois que les données sont chargées

              }))
              .catch((error) => console.log(error));
          },
          loadCalculTaux(){
              axios.get(`api/dashboard/calculTaux/${this.store_id}`)
              .then((response =>{
                  console.log(response.data.tauxRemboursement);
                  this.tauxRemboursement= response.data.tauxRemboursement;
                  this.tauxConversion= response.data.tauxConversion;
                  console.log(this.tauxConversion);
              }))
              .catch((error) => console.log(error));
          },
          createChart() {
            var ticksStyle = {
              fontColor: '#495057',
              fontStyle: 'bold'
            }

            var mode = 'index'
            var intersect = true;

            var $visitorsChart = $('#visitors-chart');
            function convertirMoisEnFrancais(moisAnglais) {
              switch (moisAnglais) {
                case 'January':
                  return 'janvier';
                case 'February':
                  return 'février';
                case 'March':
                  return 'Mars';
                case 'April':
                  return 'Avril';
                case 'May':
                  return 'Mai';
                case 'June':
                  return 'Juin';
                case 'July':
                  return 'Juillet';
                case 'August':
                  return 'Août';
                case 'September':
                  return 'Septembre';
                case 'October':
                  return 'Octobre';
                case 'November':
                  return 'Novembre';
                case 'December':
                  return 'Décembre';
                default:
                  return moisAnglais;
              }
            }

            // Utilisez la fonction pour mapper les dates
            var nomsDesMoisEnFrancais = this.commandesParAnnee.map((item) => convertirMoisEnFrancais(item.dateDebut));
            var visitorsChart = new Chart($visitorsChart, {
              data: {
                labels: nomsDesMoisEnFrancais,
                datasets: [
                  {
                    type: 'line',
                    data: this.commandesParAnnee.map((item) => item.nombreDeCommandes),
                    backgroundColor: 'transparent',
                    borderColor: '#01295E',
                    pointBorderColor: '#01295E',
                    pointBackgroundColor: '#01295E',
                    fill: false,
                  },
                  {
                    type: 'line',
                    data: this.commandesParAnneeDerniere.map((item) => item.nombreDeCommandes),
                    backgroundColor: 'tansparent', // Vérifiez la faute de frappe ici
                    borderColor: '#ced4da',
                    pointBorderColor: '#ced4da',
                    pointBackgroundColor: '#ced4da',
                    fill: false,
                  },
                ],
              },
              options: {
                maintainAspectRatio: false,
                tooltips: {
                  mode: mode,
                  intersect: intersect,
                },
                hover: {
                  mode: mode,
                  intersect: intersect,
                },
                legend: {
                  display: false,
                },
                scales: {
                  yAxes: [
                    {
                      gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent',
                      },
                      ticks: $.extend(
                        {
                          beginAtZero: true,
                          suggestedMax: Math.max.apply(
                            null,
                            this.commandesParAnnee.map((item) => item.nombreDeCommandes)
                          ),
                        },
                        ticksStyle
                      ),
                    },
                  ],
                  xAxes: [
                    {
                      display: true,
                      gridLines: {
                        display: false,
                      },
                      ticks: ticksStyle,
                    },
                  ],
                },
              },
            });
          },
          createChartSales(){
            var ticksStyle = {
              fontColor: '#495057',
              fontStyle: 'bold'
            }

            var mode = 'index'
            var intersect = true;
            var $salesChart = $('#sales-chart')
            // eslint-disable-next-line no-unused-vars
            function convertirMoisEnFrancais(moisAnglais) {
              switch (moisAnglais) {
                case 'January':
                  return 'janvier';
                case 'February':
                  return 'février';
                case 'March':
                  return 'Mars';
                case 'April':
                  return 'Avril';
                case 'May':
                  return 'Mai';
                case 'June':
                  return 'Juin';
                case 'July':
                  return 'Juillet';
                case 'August':
                  return 'Aout';
                  case 'September':
                  return 'Septembre';
                case 'October':
                  return 'Octobre';
                case 'November':
                  return 'Novembre';
                case 'December':
                  return 'Decembre';
                // Ajoutez des cas pour les autres mois
                default:
                  return moisAnglais; // Si le mois n'est pas trouvé, retournez le nom anglais d'origine
              }
            }
            var nomsDesMoisEnFrancais = this.ventesParMois.map((item) => convertirMoisEnFrancais(item.mois));
            var salesChart = new Chart($salesChart, {
              type: 'bar',
              data: {
                labels: nomsDesMoisEnFrancais,
                datasets: [
                  {
                    backgroundColor: '#01295E',
                    borderColor: '#01295E',
                    data: this.ventesParMois.map((item) => item.totalVente)
                  },
                  // {
                  //   backgroundColor: '#ced4da',
                  //   borderColor: '#ced4da',
                  //   data: 
                  // }
                ]
              },
              options: {
                maintainAspectRatio: false,
                tooltips: {
                  mode: mode,
                  intersect: intersect
                },
                hover: {
                  mode: mode,
                  intersect: intersect
                },
                legend: {
                  display: false
                },
                scales: {
                  yAxes: [{
                    // display: false,
                    gridLines: {
                      display: true,
                      lineWidth: '4px',
                      color: 'rgba(0, 0, 0, .2)',
                      zeroLineColor: 'transparent'
                    },
                    ticks: $.extend(
                        {
                          beginAtZero: true,
                          suggestedMax: Math.max.apply(
                            null,
                            this.ventesParMois.map((item) => item.totalVente)                          ),
                        },
                        ticksStyle
                      ),
                  }],
                  xAxes: [{
                    display: true,
                    gridLines: {
                      display: false
                    },
                    ticks: ticksStyle
                  }]
                }
              }
            })
          }
          
    },
    computed: {
      totalSales() {
        // Calculez le total des ventes de tous les produits.
        return this.produits.reduce((total, produit) => total + produit.count, 0);
      },
    },
  // mounted(){
  //   var ticksStyle = {
  //   fontColor: '#495057',
  //   fontStyle: 'bold'
  // }

  // var mode = 'index'
  // var intersect = true

  // var $salesChart = $('#livreur-chart')
  // // eslint-disable-next-line no-unused-vars
  // var salesChart = new Chart($salesChart, {
  //   type: 'bar',
  //   data: {
  //     labels: ['JUIN', 'JUIL', 'AOUT', 'SEP', 'OCT', 'NOV', 'DEC'],
  //     datasets: [
  //       {
  //         backgroundColor: '#01295E',
  //         borderColor: '#01295E',
  //         data: [1000, 2000, 3000, 2500, 2700, 2500, 3000]
  //       },
  //       {
  //         backgroundColor: '#ced4da',
  //         borderColor: '#ced4da',
  //         data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
  //       }
  //     ]
  //   },
  //   options: {
  //     maintainAspectRatio: false,
  //     tooltips: {
  //       mode: mode,
  //       intersect: intersect
  //     },
  //     hover: {
  //       mode: mode,
  //       intersect: intersect
  //     },
  //     legend: {
  //       display: false
  //     },
  //     scales: {
  //       yAxes: [{
  //         // display: false,
  //         gridLines: {
  //           display: true,
  //           lineWidth: '4px',
  //           color: 'rgba(0, 0, 0, .2)',
  //           zeroLineColor: 'transparent'
  //         },
  //         ticks: $.extend({
  //           beginAtZero: true,

  //           // Include a dollar sign in the ticks
  //           callback: function (value) {
  //             if (value >= 1000) {
  //               value /= 1000
  //               value += 'k'
  //             }

  //             return '$' + value
  //           }
  //         }, ticksStyle)
  //       }],
  //       xAxes: [{
  //         display: true,
  //         gridLines: {
  //           display: false
  //         },
  //         ticks: ticksStyle
  //       }]
  //     }
  //   }
  // })
  //   }
  }

</script>
<style scoped>
  
  /* Messages de bienvenue */
  .welcome-message {
    background-color: rgba(255, 255, 255, 0.9);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    margin: 20px;
    max-width: 70%;
  }
  
  .welcome-message h1 {
    font-size: 32px;
    font-weight: bold;
    margin-bottom: 10px;
    animation: fadeIn 2s;
    white-space: normal; 
    
  }
  
  .welcome-message p {
    font-size: 16px;
    margin-bottom: 20px;
    white-space: normal; 
    animation: fadeIn 2s;
  }
  button {
  background-color: #E96423;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  margin-left: 10px;
}

button:hover {
  background-color: #A96423;
}
</style>