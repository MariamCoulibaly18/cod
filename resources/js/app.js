/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


window.$ = window.jQuery = require('jquery');
require('./bootstrap');
import moment from 'moment';
import Form from 'vform';
import VueRouter from 'vue-router'
import Swal from 'sweetalert2'
import VueProgressBar from 'vue-progressbar'
import {
  Button,
  HasError,
  AlertError,
  AlertErrors,
  AlertSuccess
} from 'vform/src/components/bootstrap5'
import Gate from './Gate';
import { store } from './store';
import Vue from 'vue';
import axios from 'axios';

Vue.prototype.$gate = new Gate(window.user);

window.Vue = require('vue').default;
window.Form= Form;
window.Swal = Swal;
Vue.use(VueRouter)
window.fire = new Vue();  

Vue.component(Button.name, Button)
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertErrors.name, AlertErrors)
Vue.component(AlertSuccess.name, AlertSuccess)
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const Toast = Swal.mixin({
    toast: true,
    position: 'top-center',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
window.Toast = Toast;  




Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
})

//the routes
const routes = [
  { path: '/home', component: require('./components/Dashboard.vue').default },
  { path: '/users', component: require('./components/Users.vue').default },
  { path: '/profile', component: require('./components/Profile.vue').default },
  { path: '/commande',name:'orders', component: require('./components/Orders.vue').default },
  { path: '/commande_new',name:'order_new', component: require('./components/Order_New.vue').default },
  { path: '/commande_edit',name:'order_edit', component: require('./components/Order_Edit.vue').default },
  { path: '/product',name:"products", component: require('./components/Products.vue').default },
  { path: '/categories', component: require('./components/CategoriesProduits.vue').default },
  { path:'/client',name:"costumers", component: require('./components/Costumers.vue').default},
  { path: '/fournisseurs', component: require('./components/Fournisseurs.vue').default },
  { path:'/marques' , component: require('./components/Marques.vue').default},
  { path:'/boutiques', name:'boutiques',component: require('./components/Boutiques.vue').default},
  { path:'/boutiqueTypes', component: require('./components/BoutiquesTypes.vue').default},
  { path:'/facture-direct',name:'facture-direct', component: require('./components/FactureDirect.vue').default},
  { path:'/facture-process',name:'facture-process', component: require('./components/FactureProcess.vue').default},
  { path:'/facture-transaction',name:'facture-transaction', component: require('./components/FactureTransaction.vue').default},
  { path: '/brand',name:'brands', component: require('./components/Brands.vue').default },
  { path: '/transaction',name:'transactions' , component: require('./components/Transactions.vue').default },
  { path: '/societe-transport',name:'societe-transport' , component: require('./components/SocieteTransport.vue').default },
  { path: '/livreur',name:'livreur' , component: require('./components/Livreurs.vue').default },
  { path: '/assignedCommande',name:'assignedCommande' , component: require('./components/ScreenLivreur.vue').default },
  { path: '/pointVente',name:'pointVente' , component: require('./components/PointVentes.vue').default },
  { path: '/business_expense',name:'business_expense' , component: require('./components/BusinessExpenses.vue').default },
  { path: '/team_expense',name:'team_expense' , component: require('./components/TeamExpenses.vue').default },
  { path: '/category_expense',name:'category_expense' , component: require('./components/CategoryExpense.vue').default },
  { path: '/expenseLivreur',name:'expenseLivreur' , component: require('./components/LivreurExpense.vue').default },
  { path: '/messageries',name:'messageries' , component: require('./components/Messageries.vue').default },

]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })
  
  /**filter in vue js globaly**/
  Vue.filter('upText', function(value) {
    if (!value) return ''
    return value.toString().charAt(0).toUpperCase() + value.slice(1)
  })
  Vue.filter('myDate', function(value){
    if (!value) return ''
   return  moment(value).format('MMMM Do YYYY, h:mm:ss a')
  })
  Vue.filter('store_type_icon_filter', function(value){
      return 'images/stores/'+value;
  })
  //filter for prix format (xxx.xxx.xxx DH)
  Vue.filter('prix', function(value){
    //if (!value) return ''
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+' DH';
  })

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//I need to listen to click event on the logout button to clear the local storage


// new Vue({
//   societeTransport, // Lier le store à l'instance Vue
//   // Autres options de configuration
// }).$mount('#app');

//const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZGE1Mjk5ZmQwNDA3ODJhNmJlY2FmMGE5ZDc1MjhjYjhkMzI1M2M0NTMwNmE5ZDQ4ZDBiMzE0YjZjNTdhZTk4MjkyMDVlMjQxMzZlOTUxNzYiLCJpYXQiOjE2ODY5OTQyNzEuMDM0MjExLCJuYmYiOjE2ODY5OTQyNzEuMDM0MjE1LCJleHAiOjE3MTg2MTY2NzEuMDI0NzE3LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.UEpQLiEBFuIGQdqF5Sd9x6nIB5Qsfwf3nv9YEiJj3tTl4GWzIfW62IAcI39SQNSG8NLJft_XUSo2TYDM_VKLlIfcjcqq68pUeF4CzR3LM1v9vzTC0liPMxz7k1L-Ma6MFQB3F_N_Kn2cM-mLYEgd28R8c-OXIBmGEVV3OvTPBJPJgZjVXov65C6dl6j73aTd3R2Z1c3lcyq0MJHKD2ote9lEu3BRWE70fXi3sPxeVAK9MLYnP2BaELXaZ7uzqmU_6e7pBd8eDUzNVpe_aq0EeErArOZDNeOtGnY1P8lNgA0XWeG20n8XyD4gZwwld6UroqqYZWNWw9t7I7qKtvduTIEVaYeUgfBmHrIO1fgZ4Ku6yb78mZU7sd-WIll1g2NniNRMDiZ7To4432fstxQzE6Y2zg_j10uJgJzjkdsJ4QKVQkUCh1b2QE7SL7_Go_DPFzm1mh3mmr3ILMt6aJLB0umEVVeTenE9I2viCpvN1pi5K-wd4Wzl1yOiC-SZwghcqZTuTlpUh-cUinnr_sAI3dK5MrR7uUuAmT0CUbm8NPxYVCLThYEleJNqK7KqNKnvnVRvtwgejBvRtbI5z8yuiiTGqcGZZPO6TrB2Y6v2AvNECJL1LcqiukcAie2GT-tPPbp34TXlO88POlWGq2ZaxjiKMr6QBjSI-XcopHqeoSk';
//axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

//get the access token from the server and store it in the local storage
axios.get('/getAccessToken')
.then(response => {
  localStorage.setItem('access_token', response.data.access_token);
  //axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.access_token}`;
})
.catch(error => {
  console.log(error);
});

// loader
import BeatLoader from 'vue-spinner/src/BeatLoader.vue';
BeatLoader.props.color.default = '#20516f';
BeatLoader.props.loading.default = true;
BeatLoader.props.size.default = '10px';

Vue.component('loader',BeatLoader);

const app = new Vue({
  el: '#app',
  router,
  store,
  computed:{
    currentBoutique(){
      return this.$store.getters.currentBoutique;
    },
    currentSocieteTransport(){
      return this.$store.getters.currentSocieteTransport;
    }
  },
  watch:{
    currentBoutique(){
      if(this.currentBoutique == null){
        $('#currentBoutique').text('Aucune boutique selectionnée');
        $('#boutiqueManagement').hide();
      }else{  
        $('#boutiqueManagement').show();
        $('#currentBoutique').text(this.currentBoutique.name);
      }
    },
    currentSocieteTransport(){
      if(this.currentSocieteTransport == null){
        $('#currentSocieteTransport').text('Aucune societe de transport selectionnée');
        $('#societeTransportManagement').addClass('hidden');
      }else{  
        
        $('#societeTransportManagement').removeClass('hidden');
        $('#currentSocieteTransport').text(this.currentSocieteTransport.name);
      }
    }
  },
  created(){
    window.addEventListener('unload', this.handleUnload);
    window.addEventListener('unload', this.handleUnloadSocieteTransport);
    if(localStorage.getItem('currentBoutique') != null){
      this.$store.commit('switchBoutique', JSON.parse(localStorage.getItem('currentBoutique')));
    }
    if(localStorage.getItem('currentSocieteTransport') != null){
      this.$store.commit('switchSocieteTransport', JSON.parse(localStorage.getItem('currentSocieteTransport')));
    }
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('access_token')}`;
    
  },
  //
  beforeDestroy(){
    console.log('before destroy');
    window.removeEventListener('unload', this.handleUnload);
    window.removeEventListener('unload', this.handleUnloadSocieteTransport);

  },
  methods:{
    handleUnload(){
      if(this.currentBoutique != null)
        localStorage.setItem('currentBoutique', JSON.stringify(this.currentBoutique));
      else
        localStorage.removeItem('currentBoutique');  
    },
    handleUnloadSocieteTransport(){
      if(this.currentSocieteTransport != null)
        localStorage.setItem('currentSocieteTransport', JSON.stringify(this.currentSocieteTransport));
      else
        localStorage.removeItem('currentSocieteTransport');  
    },

  }
    
  });

        
