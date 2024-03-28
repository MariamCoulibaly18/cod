import Vue from "vue";
import Vuex from 'vuex';
import axios from 'axios'; // Importez axios pour effectuer des appels API
Vue.use(Vuex);

export const store = new Vuex.Store({
    state:{
        boutique:null,
        societeTransport:null,
        products: [], // Nouveau state pour les produits
        categories: [], // Nouveau state pour les catégories
        isLoading: false,
    },
    //getters are used to get the state data , they are like computed properties
    getters:{
        currentBoutique:state=>{
            return state.boutique;
        },
        currentSocieteTransport:state=>{
            return state.societeTransport;
        },
        products: state => {
            return state.products;
        },
        categories: state => {
            return state.categories;
        },
    },
    //mutations are used to change the state data,payload means the data that we want to pass to the mutation
    mutations:{
        switchBoutique:(state,payload)=>{
            state.boutique=payload;
        },
        switchSocieteTransport:(state,payload)=>{
            state.societeTransport=payload;
        },
        setProducts: (state, products) => { // Nouvelle mutation pour les produits
            state.products = products;
        },
        setCategories: (state, categories) => { // Nouvelle mutation pour les catégories
            state.categories = categories;
        },
        setLoading: (state, status) => {
            state.isLoading = status;
        },
    },
    //actions are used to call the mutations
    actions:{
        switchBoutique:(context,payload)=>{
            context.commit('switchBoutique',payload);
        } ,
        switchSocieteTransport:(context,payload)=>{
            context.commit('switchSocieteTransport',payload);
        },
         // Nouvelle action pour récupérer les produits depuis l'API
        //  fetchProducts: (context, store_id) => {
        //     // Remplacez l'URL de l'API avec l'URL appropriée pour récupérer les produits en utilisant le store_id
        //     axios.get(`api/product/${store_id}`)
        //         .then(response => {
        //             context.commit('setProducts', response.data); // Commitez la mutation setProducts avec les données récupérées
        //         })
        //         .catch(error => console.error(error));
        // },
        fetchProducts: (context, store_id) => {
            context.commit('setLoading', true); // Activez isLoading

            axios.get(`api/product/${store_id}`)
                .then(response => {
                    context.commit('setProducts', response.data);
                })
                .catch(error => console.error(error))
                .finally(() => {
                    context.commit('setLoading', false); // Désactivez isLoading, que la requête réussisse ou échoue
                });
        },
        // fetchProducts: (context, { store_id, page }) => {
        //     context.commit('setLoading', true); // Activez isLoading
        
        //     axios.get(`api/product/${store_id}/page/${page}`)
        //         .then(response => {
        //             context.commit('setProducts', response.data);
        //         })
        //         .catch(error => console.error(error))
        //         .finally(() => {
        //             context.commit('setLoading', false); // Désactivez isLoading, que la requête réussisse ou échoue
        //         });
        // },
        
        // Nouvelle action pour récupérer les catégories depuis l'API
        fetchCategories: (context, store_id) => {
            // Remplacez l'URL de l'API avec l'URL appropriée pour récupérer les catégories
            axios.get(`api/category/${store_id}`)
                .then(response => {
                    context.commit('setCategories', response.data); // Commitez la mutation setCategories avec les données récupérées
                })
                .catch(error => console.error(error));
        },  
    }        
})