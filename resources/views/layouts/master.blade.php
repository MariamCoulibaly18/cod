<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="shortcut icon" type="image/png" href="/images/icon.png">
        <title>GTEL| COD</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/app.css"> 
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
        
        {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script> --}}
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap">
        <style>
            .hidden {
                display: none !important;
            }
            .card {
                border-radius: 10px !important; /* Remplacez la valeur selon vos préférences */
            }
            .card-header {
                background-color: #2f4fb1 !important;
                color: white !important;
            }
            .form-control::placeholder {
                color: #333 !important;
            }
            th,td {
                text-align: center !important;
                font-family: 'Inter', 'Times New Roman', Times, serif !important;
            }
            .table td {
                white-space: normal !important;
            }
            /* h3,p{
                font-family: poppins !important;
            } */
            button{
                font-family: 'Inter' !important;
            }
            /* .btn-info{
               background-color: #3b62d4 !important;
            } */
            .modal-footer button{
                font-family: 'Inter' !important;
                width: 150px !important;
                height: 40px !important;
            }
            .modal-content{
                border-radius: 20px; /* Remplacez la valeur selon vos préférences */
            }
            .router-link-exact-active {
                background-color: #E96423  !important;
                color: #fff !important;
            }
            /* Appliquer la police arrondie au corps du site */
            /* Appliquer la police "Roboto" au corps du tableau de bord */
            /* Appliquer la police "Inter" au corps du tableau de bord */
            body {
                font-family: 'Inter', sans-serif;
                background-color: white;
                font-size: 14px; 
                /* padding-top: 30px;  */
            }

            /* Exemple d'application de la police   des  l ments sp cifiques dans le tableau de bord */
            h1, h2, h3 {
                font-family: 'Inter', sans-serif;
            }

            p {
                font-family: 'Inter', sans-serif;
            }
            /* Style pour les notifications lues */
            .read-notification {
                background-color: rgb(242, 248, 242);
                color: black;
            }
            /* Style pour l'ic ne de la cloche avec des notifications non lues */
            .notification-icon.badge {
                /*Style pour l'ic ne de la cloche lorsque des notifications non lues sont pr sentes */
                color: #FFB702;
            }
            /* Style pour le badge vert */
            .badge-success {
                /* Style pour le badge vert */
                background-color: #28A745;
                padding-left: 3px;
                padding-right: 3px;
            }
            .badge-danger {
                /* Style pour le badge rouge */
                background-color: red;
            }
            .dropdown-item img {
                max-width: 30px; /* Ajustez la taille selon vos besoins */
                max-height: 30px;
                border-radius: 50%; /* Pour les rendre rondes si elles ne le sont pas déjà */
            }
            .custom-heading {
                font-size: 14px; /* Ajustez la taille selon vos besoins */
                font-weight: 600; /* Pour un gras léger, vous pouvez ajuster la valeur */
            }
            .content-wrapper {
                z-index: 2;
                margin-bottom: 60px; /* Ajustez la valeur selon vos besoins */
            }
            /* nav.main-header {
                position: fixed;
                top: 0;
                box-sizing: border-box;
                display: flex;
                flex-wrap: wrap;
                padding-left: 0;
                margin-bottom: 0;
                list-style: none;
                position: fixed;
                background-color: #E5E6E7;
            } */
            /* .sub-menu {
                list-style-type: none;
            } */
        </style>
    </head>
    <body class="hold-transition sidebar-mini">
        
        <div class="wrapper" id="app">
            {{-- <div class="notification-container"></div> --}}
            <nav class="main-header navbar navbar-expand navbar-white navbar-light" 
                style="background-color: #E5E6E7;display: flex; flex-direction: row; align-items: center;
                    justify-content: space-between;">
                {{-- Navbar pour le nom de la boutique courante et la notification --}}
                <ul class="navbar-nav" >
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color:#552561"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">     
                            <p id="currentBoutique" style="color:#01356F"></p>        
                        </a>
                    </li>
                    <li class="nav-item">
                        
                    </li>
                </ul>
                <ul class="navbar-nav" >
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-icon-hover notification-icon" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="true">
                            <i class="fas fa-bell" style="color:#01356F"></i>
                            <span class="notification-count" id="notification-count">0</span>
                            {{-- <div class="notification bg-primary rounded-circle"></div> --}}
                        </a>
                        <div id="notification-container" class="dropdown-menu content-dd dropdown-menu-end" aria-labelledby="drop2" data-bs-popper="static" style="padding: 30px; border-radius: 10px !important;">
                            <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                                <span class="badge text-bg-primary rounded-4 px-3 py-1 1h-sm text-white" id="new-notification-count"> </span>
                            </div>
                            <div class="message-body simplebar-scrollable-y" data-simplebar="init">
                                <div class="simplebar-wrapper" style="margin: 0;">
                                    <div class="simplebar-mask">
                                        <div class="simplebar-offset" style="right: 0; bottom: 0;">
                                            <div class="simplebar-content">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            
                            <div class="py-6 px-7 mb-1">
                                <button class="btn btn-outline-primary w-100" data-toggle="modal" data-target="#notificationModal">Voir tous</button>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="user-panel d-flex">
                            <div class="info">
                                <router-link to="/profile" class="d-block" style="color:#01356F"> {{ auth()->user()->name}}</router-link>
                            </div>
                            <div class="image">
                                <img src="{{ asset('/images/profile/' . auth()->user()->image) }}" class="img-circle elevation-2" alt="User Image" style="width:40px;height:40px">
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
            <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color:#223d8d">
                <a href="index3.html" class="brand-link">
                    <img src="{{ asset('images/icon.png') }}" alt="GTEL Logo" class="brand-image img-circle elevation-3" style="opacity: .8;width:50px;height:50px">
                    <span class="brand-text font-weight-light" style="color:#ffff">GTEL COD</span>
                </a>
                <div class="sidebar">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <router-link to="/home" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt" style="color:#ffff"></i>
                                <p style="color:#ffff">Tableau de bord</p>
                                </router-link>
                            </li>
                            @can('is-super-admin')
                            <li class="nav-item">
                                <router-link to="/users" class="nav-link ">
                                <i class="nav-icon fas fa-users" style="color:#ffff"></i>
                                <p style="color:#ffff">
                                Utilisateurs
                                </p>
                                </router-link>
                            </li>
                            @endcan
                            @can('is-admin')
                            <li class="nav-item">
                                <router-link to="/boutiques" class="nav-link ">
                                    <i class="nav-icon fas fa-store" style="color:#ffff"></i>
                                    <p style="color:#ffff">
                                        Boutiques
                                        <i class="right fas fa-angle-down"></i>
                                    </p>
                                </router-link>
                                @can('is-super-admin')
                                <ul class="nav-pills nav-sidebar flex-column sub-menu" data-widget="treeview" role="menu" data-accordion="false">
                                    <li class="nav-item">
                                    <router-link to="/boutiqueTypes" class="nav-link ">
                                        <i class="fas fa-angle-right nav-icon" style="color:#ffff"></i>
                                        <p style="color:#ffff" >Types</p>
                                    </router-link>
                                    </li>
                                </ul>
                                @endcan
                            </li>
                            @endcan
                            <div class="" id="boutiqueManagement" style="display: none">
                                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                    <li class="nav-item">
                                        <router-link to="/commande" class="nav-link ">
                                        <i class="nav-icon fas fa-shopping-cart" style="color:#ffff"></i>
                                        <p style="color:#ffff">Commandes</p>
                                        </router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link to="/product" class="nav-link ">
                                            <i class="nav-icon fas fa-bag-shopping" style="color:#ffff"></i>
                                            <p style="color:#ffff">
                                                Produits
                                                <i class="right fas fa-angle-down"></i>
                                            </p>
                                        </router-link>
                                        <ul  class="nav-pills nav-sidebar flex-column sub-menu" data-widget="treeview" role="menu" data-accordion="false">
                                            <li class="nav-item">
                                            <router-link to="/categories" class="nav-link ">
                                                <i class="fas fa-angle-right nav-icon" style="color:#ffff"></i>
                                                <p style="color:#ffff" class="hide-menu">Categories</p>
                                            </router-link>
                                            </li>
                                            <li class="nav-item">
                                                <router-link to="/brand" class="nav-link ">
                                                    <i class="fas fa-angle-right nav-icon" style="color:#ffff"></i>
                                                    <p style="color:#ffff">
                                                        Marques
                                                    </p class="hide-menu">
                                                </router-link>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <router-link to="/client" class="nav-link ">
                                            <i class="nav-icon fas fa-user" style="color:#ffff"></i>
                                            <p style="color:#ffff">
                                                Clients
                                            </p>
                                        </router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link to="/transaction" class="nav-link ">
                                            <i class="nav-icon fas fa-exchange-alt" style="color:#ffff"></i>
                                            <p style="color:#ffff">
                                            Transactions
                                            </p>
                                        </router-link>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link facture">
                                            <i class="nav-icon fas fa-file-invoice-dollar" style="color:#ffff"></i>
                                            <p style="color:#ffff">
                                                Factures
                                                <i class="right fas fa-angle-down"></i>
                                            </p>
                                        </a>
                                        <ul id="factureSubMenu" class="nav-pills nav-sidebar flex-column sub-menu" data-widget="treeview" role="menu" data-accordion="false">
                                            <li class="nav-item">
                                                <router-link to="/facture-direct" class="nav-link ">
                                                    <i class="fas fa-angle-right nav-icon" style="color:#ffff"></i>
                                                    <p style="color:#ffff">Direct</p>   
                                                </router-link>
                                            </li>
                                            <!--process-->
                                            <li class="nav-item">
                                                <router-link to="/facture-process" class="nav-link ">
                                                    <i class="fas fa-angle-right nav-icon" style="color:#ffff"></i>
                                                    <p style="color:#ffff">Process</p>   
                                                </router-link>
                                            </li>
                                            <!--Transaction-->
                                            <li class="nav-item">
                                                <router-link to="/facture-transaction" class="nav-link ">
                                                    <i class="fas fa-angle-right nav-icon" style="color:#ffff"></i>
                                                    <p style="color:#ffff">Transaction</p>   
                                                </router-link>
                                            </li> 
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <router-link to="/societe-transport" class="nav-link ">
                                            <i class="nav-icon fas fa-shipping-fast" style="color:#ffff"></i>
                                            <p style="color:#ffff"> Societes de transport </p>
                                        </router-link>
                                    </li>
                                    <div id="societeTransportManagement" class="hidden">
                                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                            <li class="nav-item">
                                                <router-link to="/livreur" class="nav-link ">
                                                    <i class='nav-icon fa-solid fa-people-carry-box' style="color:#ffff"></i>
                                                    <p style="color:#ffff">
                                                        Livreurs
                                                    </p>
                                                </router-link>
                                            </li>
                                        </ul>
                                    </div>
                                    <li class="nav-item">
                                        <router-link to="/pointVente" class="nav-link ">
                                            <i class="nav-icon fa-solid fa-location-dot" style="color:#ffff"></i>
                                            <p style="color:#ffff">
                                                Point de ventes
                                            </p>
                                        </router-link>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link depense">
                                            <i class="nav-icon fa-solid fa-sack-dollar" style="color:#ffff"></i>
                                            <p style="color:#ffff">
                                                Depenses
                                            <i class="right fas fa-angle-down"></i>
                                            </p>
                                        </a>
                                        <ul class="nav-pills nav-sidebar flex-column sub-menu" data-widget="treeview" role="menu" data-accordion="false" id="depenseSubMenu">
                                            <li class="nav-item">
                                                <router-link to="/business_expense" class="nav-link">
                                                    <i class="fas fa-angle-right nav-icon" style="color:#ffff"></i>
                                                    <p style="color:#ffff">De l'Entreprise</p>
                                                </router-link>
                                            </li>
                                            <li class="nav-item">
                                                <router-link to="/team_expense" class="nav-link">
                                                    <i class="fas fa-angle-right nav-icon" style="color:#ffff"></i>
                                                    <p style="color:#ffff">De l'equipe</p>
                                                </router-link>
                                            </li>
                                            <li class="nav-item parametre">
                                                <a href="#" class="nav-link">
                                                    <i class="fas fa-angle-right nav-icon" style="color:#ffff"></i>
                                                    <p style="color:#ffff">
                                                        Parametres
                                                        <i class="right fas fa-angle-left"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview"> 
                                                    <li class="nav-item" style= "margin-left:5px;">
                                                        <router-link to="/category_expense" class="nav-link">
                                                            <i class="fas fa-angle-right nav-icon" style="color:#ffff"></i>
                                                            <p style="color:#ffff">Categories</p>
                                                        </router-link>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <router-link to="/messageries" class="nav-link ">
                                            <i class="nav-icon fa fa-comments" aria-hidden="true" style="color:#ffff"></i>
                                            <p style="color:#ffff">
                                            Messageries
                                            </p>
                                        </router-link>
                                    </li>
                                    @can('is-super-admin')
                                    <li class="nav-item">
                                        <router-link to="/fournisseurs" class="nav-link ">
                                            <i class="nav-icon fas fa-users" style="color:#ffff"></i>
                                            <p style="color:#ffff">
                                            Fournisseurs
                                            </p>
                                        </router-link>
                                    </li>
                                    @endcan
                                </ul>
                            </div>
                           
                            @can('is-livreur')
                            <li class="nav-item">
                                <router-link to="/assignedCommande" class="nav-link ">
                                <i class="nav-icon fas fa-users" style="color:#ffff"></i>
                                <p style="color:#ffff">
                                Mes commandes
                                </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/expenseLivreur" class="nav-link ">
                                <i class="fa-solid fa-sack-dollar" style="color:#ffff"></i>
                                <p style="color:#ffff">
                                Mes depenses
                                </p>
                                </router-link>
                            </li>
                            @endcan
                            <li class="nav-item has-treeview ">
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="nav-icon fas fa-power-off red" ></i>
                                    <p style="color:#ffff">{{ __('Se deconnecter') }}</p>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            <li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <div class="content-wrapper" style="background-color: #FFFFFF !important;">
                <div class="content-header mt-3 ml-5">
                </div>
                <div class="content">
                    <div style="container-fluid">

                        <router-view></router-view>
                        <!-- set progressbar -->
                        <vue-progress-bar></vue-progress-bar>

                    </div>
                </div>
            </div>
            <aside class="control-sidebar control-sidebar-dark">

                <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
                </div>
            </aside>
        </div>

        <footer class="main-footer" style="background-color:light-gray; position: fixed; bottom: 0; width: 100%;z-index: 1;  padding: 10px;">
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <strong>Copyright &copy; 2023<a href="#">gtel</a>.</strong> All rights reserved.
        </footer>

        <!-- REQUIRED SCRIPTS -->
        {{-- <script src="{{asset('js/app.js')}}"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

        @auth
        <script>
            window.user = @json(auth()->user())
        </script>    
        @endauth

        <script  src="/js/app.js"></script>
        <script src="/plugins/chart.js/chart.min.js"></script>
        {{-- <script src="/js/dashboard3.js"></script> --}}
        <script>
 
            document.addEventListener('DOMContentLoaded', function() {
                const produitsLink = document.querySelector('a[href="/product"]');
                const boutiquesLink = document.querySelector('a[href="/boutiques"]');
                const facturesLink = document.querySelector('.facture');
                const depensesLink = document.querySelector('.depense');

                const produitsSubMenu = produitsLink.nextElementSibling;
                const boutiquesSubMenu = boutiquesLink.nextElementSibling;
                const facturesSubMenu = document.getElementById('factureSubMenu');
                const depensesSubMenu = document.getElementById('depenseSubMenu');

                // const facturesSubMenu = facturesLink.nextElementSibling.querySelector('factureSubMenu');

                function hideAllSubMenus() {
                    const allSubMenus = document.querySelectorAll(".sub-menu");
                        allSubMenus.forEach(subMenu => {
                            subMenu.style.display = "none";
                        });
                }

                const isSubMenuVisible = localStorage.getItem('isSubMenuVisible');
                if (isSubMenuVisible === 'true') {
                    hideAllSubMenus();
                    const lastActiveSubMenu = localStorage.getItem('lastActiveSubMenu');
                    if (lastActiveSubMenu === 'produits') {
                        produitsSubMenu.style.display = "block";
                    } else if (lastActiveSubMenu === 'boutiques') {
                        boutiquesSubMenu.style.display = "block";
                    } else if (lastActiveSubMenu === 'factures') {
                        facturesSubMenu.style.display = "block";
                    }else if (lastActiveSubMenu === 'depenses') {
                        depensesSubMenu.style.display = "block";
                    }
                } else {
                    hideAllSubMenus();
                }

                function handleSubMenuClick(link, subMenuName, subMenu) {
                    link.addEventListener("click", function(event) {
                        event.preventDefault();
                        const isVisible = subMenu.style.display === "block";

                        if (isVisible) {
                            subMenu.style.display = "none";
                            localStorage.setItem('isSubMenuVisible', 'false');
                        } else {
                            hideAllSubMenus();
                            subMenu.style.display = "block";
                            localStorage.setItem('isSubMenuVisible', 'true');
                            localStorage.setItem('lastActiveSubMenu', subMenuName);
                        }
                    });
                }
                handleSubMenuClick(produitsLink, 'produits', produitsSubMenu);
                handleSubMenuClick(boutiquesLink, 'boutiques', boutiquesSubMenu);
                handleSubMenuClick(facturesLink, 'factures', facturesSubMenu);
                handleSubMenuClick(depensesLink, 'depenses', depensesSubMenu);
                // handleSubMenuClick(parametresLink, 'parametres', parametresSubMenu);
                
                const notificationCountElement = document.getElementById('notification-count');
                const notificationIcon = document.querySelector('.notification-icon');
                function getRandomColor() {
                    const letters = '0123456789ABCDEF';
                    let color = '#';
                    for (let i = 0; i < 6; i++) {
                        color += letters[Math.floor(Math.random() * 16)];
                    }
                    return color;
                }
                // Fonction pour récupérer et afficher les notifications
                function fetchAndDisplayNotifications() {
                    axios.get('api/getNotifications')
                        .then(response => {
                            const notifications = response.data.notificationsRead;
                            const notificationContainer = document.getElementById('notification-container');
                            const simplebarContent = notificationContainer.querySelector('.simplebar-content');
                            simplebarContent.innerHTML = '';

                            if (notifications.length === 0) {
                                simplebarContent.innerHTML = `
                                    <a href="javascript:void(0)" class="py-2 px-7 d-flex align-items-center dropdown-item">
                                        <span class="me-3"> </span>
                                        <div class="flex-grow-1">
                                            <h6>Aucune notification pour l'instant.</h6>
                                        </div>
                                    </a>`;
                            } else {
                                notifications.forEach(notification => {
                                    const notificationStyle = notification.is_read ? 'read-notification' : 'unread-notification';
                                    const randomColor = getRandomColor();
                                    // Utiliser la première lettre du nom du livreur
                                    const firstLetter = notification.livreur_name.charAt(0).toUpperCase();
                                    // Formater la date
                                    const formattedDate = notification.formatted_date;
                                    simplebarContent.innerHTML += `
                                        <a href="javascript:void(0)" class="py-2 px-7 d-flex align-items-center dropdown-item">
                                            <span class="me-3">
                                                <div class="rounded-circle" style="width: 30px; height: 30px; background-color: ${randomColor}; color: white; display: flex; align-items: center; justify-content: center;">
                                                    ${firstLetter}
                                                </div>    
                                            </span>
                                            <div class="flex-grow-1">
                                                <h6>${notification.livreur_name}</h6>
                                                <span>${notification.message}</span>
                                                <span class="notification-date" style="display: block;">${formattedDate}</span>
                                            </div>
                                        </a>`;
                                });
                            }
                            // Mise à jour du nombre de nouvelles notifications
                            updateNewNotificationCount(notifications.length);
                            // Marquer les notifications comme lues sur le serveur
                            axios.post('api/markNotificationsAsRead')
                                .then(response => {
                                    // Mettre à jour le nombre de notifications non lues
                                    fetchNotifications();
                                })
                                .catch(error => {
                                    console.error('Erreur lors du marquage des notifications comme lues :', error);
                                });
                        })
                        .catch(error => {
                            console.error('Erreur lors de la récupération des notifications :', error);
                        });
                }
                // Fonction pour récupérer et afficher toutes les notifications
                function fetchAllNotifications() {
                    axios.get('api/getNotifications')
                        .then(response => {
                            const notifications = response.data.notifications;
                            const notificationModal = document.getElementById('notificationModal');
                            const modalBody = notificationModal.querySelector('.modal-body');
                            modalBody.innerHTML = '';
                            notifications.forEach(notification => {
                                const randomColor = getRandomColor();
                                // Utiliser la première lettre du nom du livreur
                                const firstLetter = notification.livreur_name.charAt(0).toUpperCase();
                                // Formater la date
                                const formattedDate = notification.formatted_date;
                                modalBody.innerHTML += `
                                    <a href="javascript:void(0)" class="py-2 px-7 d-flex align-items-center dropdown-item">
                                        <span class="me-3">
                                            <div class="rounded-circle" style="width: 30px; height: 30px; background-color: ${randomColor}; color: white; display: flex; align-items: center; justify-content: center;">
                                                ${firstLetter}
                                            </div>    
                                        </span>
                                        <div class="flex-grow-1">
                                            <h6>${notification.livreur_name}</h6>
                                            <span>${notification.message}</span>
                                        </div>
                                        <span class="notification-date">${formattedDate}</span>
                                    </a>`;
                            });
                            // Ouvrez le modal
                            $(notificationModal).modal('show');
                            const notificationModale = document.getElementById('notificationModal');
                            const closeModalButton = notificationModale.querySelector('.btn-secondary');
                            closeModalButton.addEventListener('click', function() {
                                // Fermez le modal
                                $(notificationModal).modal('hide');
                                // Mettez à jour le nombre de notifications non lues après la fermeture du modal
                                fetchNotifications();
                            });
                        })
                        .catch(error => {
                            console.error('Erreur lors de la récupération des notifications :', error);
                        });
                }
                // Attacher l'événement de clic sur le bouton "Voir tous"
                const voirTousButton = document.querySelector('.btn-outline-primary');
                voirTousButton.addEventListener('click', fetchAllNotifications);
                // Fonction pour mettre à jour le nombre de nouvelles notifications
                function updateNewNotificationCount(count) {
                    const newNotificationCountElement = document.getElementById('new-notification-count');
                    newNotificationCountElement.innerText = count === 0 ? 'Aucune' : `${count} ${count === 1 ? 'nouvelle' : 'nouvelles'}`;
                }
                // Fonction pour gérer le clic sur l'icône de cloche
                function handleNotificationIconClick() {
                    fetchAndDisplayNotifications();
                }
                
                // Attacher l'événement de clic sur l'icône de cloche
                document.querySelector('.notification-icon').addEventListener('click', handleNotificationIconClick);

                // Récupérer les notifications lors du chargement de la page
                fetchNotifications();

                // Fonction pour récupérer les notifications depuis le backend et mettre à jour le nombre de notifications non lues
                function fetchNotifications() {
                    axios.get('api/getNotifications')
                        .then(response => {
                            const notifications = response.data.notifications;
                            const unreadNotifications = response.data.notificationsRead;
                            const notificationCount = unreadNotifications.length;

                            // Mettre à jour le nombre de notifications non lues dans l'icône de cloche
                            const notificationCountElement = document.getElementById('notification-count');
                            notificationCountElement.innerText = notificationCount;

                            if (notificationCount > 0) {
                                notificationCountElement.classList.add('badge', 'badge-success');
                                notificationCountElement.classList.remove('badge', 'badge-danger');
                            } else {
                                notificationCountElement.classList.remove('badge', 'badge-success');
                                notificationCountElement.classList.add('badge', 'badge-danger');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors de la récupération des notifications :', error);
                        });
                }
            });
        </script>

        <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notificationModalLabel">Notifications</h5>
                    </div>
                    <div class="modal-body">
                        <!-- Le contenu des notifications sera ajout  ici -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: #3b62d4 ">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- <script>
            // Script pour rafra chir la page en ignorant le cache
            window.location.reload(true);
        </script> -->
    </body>
</html>
<style>
    .sub-menu {
        list-style-type: none;
    }
    .modal-body {
        max-height: 400px; /* Hauteur maximale à partir de laquelle le défilement apparaîtra */
        overflow-y: auto; /* Ajout du défilement vertical si nécessaire */
        }
</style>