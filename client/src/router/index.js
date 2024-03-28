import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

let routes = [
	{
		// will match everything
		path: '*',
		component: () => import('../views/404.vue'),
	},
	{
		path: '/',
		name: 'Accueil',
		redirect: '/dashboard',
	},
	{
		path: '/dashboard',
		name: 'Tableau de bord',
		layout: "dashboard",
		component: () => import(/* webpackChunkName: "dashboard" */ '../views/Dashboard.vue'),
	},
	{ path: '/utilisateur', name: 'Utilisateurs',layout: "dashboard", 
		component: () => import('../views/Utilisateur.vue'),
	},
	{ path: '/commande', name: 'Commandes',layout: "dashboard", 
		component: () => import('../views/Commande.vue'),
	},
	{ path: '/produit', name: 'Produits',layout: "dashboard", 
		component: () => import('../views/Produit.vue'),
	},
	{ path: '/client', name: 'Clients',layout: "dashboard", 
		component: () => import('../views/Client.vue'),
	},
	{ path: '/fournisseur', name: 'Fournisseurs',layout: "dashboard", 
		component: () => import('../views/Fournisseur.vue'),
	},
	{ path: '/marque', name: 'Marques',layout: "dashboard", 
		component: () => import('../views/Marque.vue'),
	},
	{ path: '/boutique', name: 'Boutiques',layout: "dashboard", 
		component: () => import('../views/Boutique.vue'),
	},
	{ path: '/typeBoutique', name: 'Types de Boutiques',layout: "dashboard", 
		component: () => import('../views/BoutiqueType.vue'),
	},
	{ path: '/factureDirecte', name: 'Factures Directes',layout: "dashboard", 
		component: () => import('../views/FactureDirecte.vue'),
	},
	{ path: '/factureProcess', name: 'Factures Process',layout: "dashboard", 
		component: () => import('../views/FactureProcess.vue'),
	},
	{ path: '/factureTransaction', name: 'Factures des Transactions',layout: "dashboard", 
		component: () => import('../views/FactureTransaction.vue'),
	},
	{ path: '/transaction', name: 'Transactions',layout: "dashboard", 
		component: () => import('../views/Transaction.vue'),
	},
	{ path: '/societeTransport', name: 'Societe de Transport',layout: "dashboard", 
		component: () => import('../views/SocieteTransport.vue'),
	},
	{ path: '/livreur', name: 'Livreurs',layout: "dashboard", 
		component: () => import('../views/Livreur.vue'),
	},
	{ path: '/commandeLivreur', name: 'Mes commandes',layout: "dashboard", 
		component: () => import('../views/CommandeLivreur.vue'),
	},
	{ path: '/pointVente', name: 'PointVente',layout: "dashboard", 
		component: () => import('../views/PointVente.vue'),
	},
	{ path: '/depenseProfessionnelle', name: 'Depenses Professionnelles',layout: "dashboard", 
		component: () => import('../views/DepenseProfessionnelle.vue'),
	},
	{ path: '/depenseEquipe', name: "Depenses de l'Equipe",layout: "dashboard", 
		component: () => import('../views/DepenseEquipe.vue'),
	},
	{ path: '/categorieDepense', name: 'Categories de Depenses',layout: "dashboard", 
		component: () => import('../views/CategorieDepense.vue'),
	},
	{ path: '/depenseLivreur', name: 'Depenses Livreurs',layout: "dashboard", 
		component: () => import('../views/DepenseLivreur.vue'),
	},

	{
		path: '/layout',
		name: 'Layout',
		layout: "dashboard",
		component: () => import('../views/Layout.vue'),
	},
	{
		path: '/tables',
		name: 'Tables',
		layout: "dashboard",
		component: () => import('../views/Tables.vue'),
	},
	{
		path: '/billing',
		name: 'Billing',
		layout: "dashboard",
		component: () => import('../views/Billing.vue'),
	},
	{
		path: '/rtl',
		name: 'RTL',
		layout: "dashboard-rtl",
		meta: {
			layoutClass: 'dashboard-rtl',
		},
		component: () => import('../views/RTL.vue'),
	},
	{
		path: '/Profile',
		name: 'Profile',
		layout: "dashboard",
		meta: {
			layoutClass: 'layout-profile',
		},
		component: () => import('../views/Profile.vue'),
	},
	{
		path: '/sign-in',
		name: 'Sign-In',
		component: () => import('../views/Sign-In.vue'),
	},
	{
		path: '/sign-up',
		name: 'Sign-Up',
		meta: {
			layoutClass: 'layout-sign-up',
		},
		component: () => import('../views/Sign-Up.vue'),
	},
]

// Adding layout property from each route to the meta
// object so it can be accessed later.
function addLayoutToRoute( route, parentLayout = "default" )
{
	route.meta = route.meta || {} ;
	route.meta.layout = route.layout || parentLayout;
	
	if( route.children )
	{
		route.children = route.children.map( ( childRoute ) => addLayoutToRoute( childRoute, route.meta.layout ) ) ;
	}
	return route ;
}

routes = routes.map( ( route ) => addLayoutToRoute( route ) ) ;

const router = new VueRouter({
	mode: 'hash',
	base: process.env.BASE_URL,
	routes,
	scrollBehavior (to, from, savedPosition) {
		if ( to.hash ) {
			return {
				selector: to.hash,
				behavior: 'smooth',
			}
		}
		return {
			x: 0,
			y: 0,
			behavior: 'smooth',
		}
	}
})

export default router
