<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<!-- Mirrored from kalanidhithemes.com/live-preview/landing-page/codely/all-demo/01-codely-landing-page-defoult/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 09 Jan 2024 10:27:25 GMT -->
<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  {{-- <title>Home</title> --}}

  <!-- icofont-css-link -->
  <link rel="stylesheet" href="cssHome/icofont.min.css">
  <!-- Owl-Carosal-Style-link -->
  <link rel="stylesheet" href="cssHome/animate.min.css">
  <!-- Owl-Carosal-Style-link -->
  <link rel="stylesheet" href="cssHome/owl.carousel.min.css">
  <!-- Bootstrap-Style-link -->
  <link rel="stylesheet" href="cssHome/bootstrap.min.css">
  <!-- Aos-Style-link -->
  <link rel="stylesheet" href="cssHome/aos.css">
  <!-- Coustome-Style-link -->
  <link rel="stylesheet" href="cssHome/style.css">
  <!-- Responsive-Style-link -->
  <link rel="stylesheet" href="cssHome/responsive.css">

  <!-- Jquery-js-Link -->
  <script src="jsHome/jquery.js"></script>

  <!-- Favicon -->
  {{-- <link rel="shortcut icon" href="imagesHome/favicon.png" type="image/x-icon"> --}}
  
  <link rel="shortcut icon" type="image/png" href="/images/icon.png">
  <title>GTEL| COD</title>

</head>

<body>


  <!-- Page-wrapper-Start -->
  <div class="page_wrapper">

    <!-- Preloader -->
    <div id="preloader">
      <!-- <div id="loader"></div> -->
      <div class="circle-border">
        <div class="circle-core"></div>
      </div>
    </div>

    <!-- Top Banner Stat-->
    <div class="top_home_wraper">

      <div class="banner_shapes">
        <div class="container">
          <span><img src="imagesHome/new/plus.svg" alt="image"></span>
          <span><img src="imagesHome/new/polygon.svg" alt="image"></span>
          <span><img src="imagesHome/new/round.svg" alt="image"></span>
        </div>
      </div>

      <!-- Header Start -->
      <header class="fixed">
        <!-- container start -->
        <div class="container">
          <!-- navigation bar -->
          <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="index.html">
              <img src="imagesHome/new/Logo.png" alt="image">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon">
                <!-- <i class="icofont-navigation-menu ico_menu"></i> -->
                <span class="toggle-wrap">
                  <span class="toggle-bar"></span>
                </span>
              </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="index.html">Accueil</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="about-us.html">A propos de nous</a>
                </li>
                <!-- secondery menu start -->
                <li class="nav-item has_dropdown">
                  <a class="nav-link" href="#">Services</a>
                  <span class="drp_btn"><i class="icofont-rounded-down"></i></span>
                  <div class="sub_menu">
                    <ul>
                      <li><a href="service-list-1.html">Service List 1</a></li>
                      <li><a href="service-list-2.html">Service List 2</a></li>
                      <li><a href="service-detail.html">Service Details </a></li>
                    </ul>
                  </div>
                </li>
                <!-- secondery menu end -->
                <li class="nav-item">
                  <a class="nav-link" href="contact-us.html">Contact</a>
                </li>
                <li class="nav-item">
                    @if (Route::has('login'))
                    <div class="signin">
                        {{-- <a href="{{ route('login') }}">S'identifier</a> --}}
                        <a class="nav-link dark_btn" href="{{ route('login') }}"> Se connecter <i class="icofont-arrow-right"></i></a>
                    </div>
                    @endif
                  {{-- <a class="nav-link dark_btn" href="contact-us.html"> Se connecter <i class="icofont-arrow-right"></i></a> --}}
                </li>
              </ul>
            </div>
          </nav>
          <!-- navigation end -->
        </div>
        <!-- container end -->
      </header>

      <!-- Banner-Section-Start -->
      <section class="banner_section">
        <div class="container">
          <div class="banner_text">
            <div class="ban_inner_text" data-aos="fade-up" data-aos-duration="1500">
              <span>Connectez, Gérez, Prospérez</span>
              <h1>Centralisez vos boutiques avec <br> simplicité et efficacité</h1>
              <p>Unifiez vos canaux, multipliez vos succès</p>
            </div>
             <!-- Boutons -->
            <div class="button-container">
                <a href="lien_vers_page_en_savoir_plus" class="btn" style="color: #FF7437; border-width: 1px solid; border-color: #FF7437; background-color:white; border-radius:30px; padding:10px 30px;">En savoir plus</a>
                <a href="lien_vers_page_nous_contacter" class="btn btn_main">Nous contacter</a>
            </div>
          </div>
          <div class="banner_images" data-aos="fade-up" data-aos-duration="1500">
            <img src="imagesHome/new/banner_01.png" alt="image">
            <div class="sub_images">
              <img class="moving_animation" src="imagesHome/new/banner_02.png" alt="image">
              <img class="moving_animation" src="imagesHome/new/banner_03.png" alt="image">
              <img class="moving_animation" src="imagesHome/new/banner_04.png" alt="image">
            </div>
          </div>
        </div>
      </section>

    </div>
    <!-- Top Banner End -->

    <!-- Unique features Start -->
    <section class="row_am unique_section">
      <div class="container">
        <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
          <!-- h2 -->
          <h2>Caractéristiques uniques</h2>
          <!-- p -->
          <p> Notre plateforme réunit des fonctionnalités clés pour optimiser votre efficacité </br> opérationnelle,
            personnaliser vos interactions client et maintenir </br> un contrôle financier précis.
          </p>
        </div>
        <div class="features_inner" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="100">
          <!-- card -->
          <div class="feature_card">
            <div class="icons">
              <img src="imagesHome/new/features_icon_01.svg" alt="image">
              <div class="dot_block">
                <span class="dot_anim"></span>
                <span class="dot_anim"></span>
                <span class="dot_anim"></span>
              </div>
            </div>
            <div class="inner_text">
              <h3>Centralisation Intuitive</h3>
              <p>Centralisez et supervisez toutes vos opérations de commerce électronique à partir d'une interface fluide. 
                Gérez les produits, les commandes, les clients, les livraisons et plus encore, en un seul endroit intuitif.
              </p>
              <a href="service-detail.html" class="btn text_btn">EN SAVOIR PLUS<i class="icofont-arrow-right"></i></a>
            </div>
          </div>
          <!-- card -->
          <div class="feature_card">
            <div class="icons">
              <img src="imagesHome/new/features_icon_02.svg" alt="image">
              <div class="dot_block">
                <span class="dot_anim"></span>
                <span class="dot_anim"></span>
                <span class="dot_anim"></span>
              </div>
            </div>
            <div class="inner_text">
              <h3>Gestion Financière Transparente</h3>
              <p>Maîtrisez les dépenses de l'entreprise et du personnel en toute clarté. Suivez les transactions, gérez les factures fournisseurs, 
                et contrôlez les dépenses individuelles avec une visibilité totale et une gestion aisée.
              </p>
              <a href="service-detail.html" class="btn text_btn">EN SAVOIR PLUS<i class="icofont-arrow-right"></i></a>
            </div>
          </div>
          <!-- card -->
          <div class="feature_card">
            <div class="icons">
              <img src="imagesHome/new/features_icon_03.svg" alt="image">
              <div class="dot_block">
                <span class="dot_anim"></span>
                <span class="dot_anim"></span>
                <span class="dot_anim"></span>
              </div>
            </div>
            <div class="inner_text">
              <h3>Automatisation Personnalisée</h3>
              <p>Créez des messages automatisés personnalisés pour chaque étape du parcours client. Du suivi de commande aux notifications spéciales, 
                offrez une expérience client exceptionnelle sans effort supplémentaire.
              </p>
              <a href="service-detail.html" class="btn text_btn">EN SAVOIR PLUS <i class="icofont-arrow-right"></i></a>
            </div>
          </div>

        </div>
      </div>
    </section>
    <!-- Unique features End -->

    <!-- Analyze Section Strat -->
    <section class="row_am analyze_section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="analyze_text" data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100">
              <span class="icon"><img src="imagesHome/new/Analyze_Icon.svg" alt="image"></span>
              <div class="section_title">
                <h2>Contrôle total sur vos paiements de factures</h2>
                <p>Suivez chaque détail de vos transactions financières avec précision grâce à notre système de gestion de facturation avancé.</p>
              </div>
              <ul>
                <li data-aos="fade-up" data-aos-duration="2000">
                  <h3>Suivi et ajustement précis des paiements</h3>
                  <p> Visualisez et ajustez les paiements de manière détaillée. 
                    Ajoutez des montants au fur et à mesure jusqu'à la complétion de la facture, avec la flexibilité de modifier les montants en cas d'erreur.
                  </p>
                </li>
                <li data-aos="fade-up" data-aos-duration="2000">
                  <h3>Gestion des statuts de facturation</h3>
                  <p> Contrôlez l'état de vos factures. Ouvrez une facture pour signaler un solde restant et fermez-la une fois le paiement complet effectué. 
                    Personnalisez vos factures selon leur origine (commandes ou transactions avec les fournisseurs) pour une gestion précise.
                  </p>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-6">
            <div class="analyze_image" data-aos="fade-in" data-aos-duration="1000">
              <img data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100" class="moving_animation"
                src="imagesHome/new/analyze-data-01.png" alt="image">
              <img data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100" class="moving_animation"
                src="imagesHome/new/analyze-data-02.png" alt="image">
              <img data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100" class=""
                src="imagesHome/new/analyze-data-03.png" alt="image">
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Analyze Section End -->

    <!-- Collaborate Section Strat -->
    <section class="row_am collaborate_section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="collaborate_image" data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100">
              <div class="img_block" data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100">
                <img class="icon_img moving_animation" src="imagesHome/new/Collaborate-icon_1.png" alt="image">
                <img src="imagesHome/new/Collaborate-01.png" alt="image">
              </div>
              <div class="img_block" data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100">
                <img src="imagesHome/new/Collaborate-02.png" alt="image">
                <img class="icon_img moving_animation" src="imagesHome/new/Collaborate-icon_2.png" alt="image">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="collaborate_text" data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100">
              <span class="icon"><img src="imagesHome/new/securely.svg" alt="image"></span>
              <div class="section_title">
              <h2>Soyez maître de la traçabilité</h2>
              <p>Gérez et suivez l'évolution de chaque commande, attribuez des livreurs et assurez-vous que vos clients reçoivent leurs colis rapidement, 
                le tout depuis une interface intuitive.
              </p>
              </div>
              <ul>
                <li data-aos="fade-up" data-aos-duration="2000">
                <h3>Suivi complet des commandes</h3>
                <p>Visualisez chaque étape de la commande, de l'acceptation par le livreur à la livraison finale,
                  offrant à vos clients une transparence totale sur leur achat.
                </p>
                </li>
                <li data-aos="fade-up" data-aos-duration="2000">
                <h3>Attribution des livreurs simplifiée</h3>
                <p>Assignez aisément les livreurs aux commandes, optimisant ainsi le processus de 
                  livraison et assurant la satisfaction de vos clients à chaque étape.
                </p>
                </li>
              </ul>
              <a href="service-detail.html" data-aos="fade-up" data-aos-duration="2000" class="btn btn_main">EN SAVOIR PLUS <i
                  class="icofont-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Analyze Section End -->

    <!-- Communication Section Strat -->
    <!-- <section class="row_am communication_section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="communication_text" data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100">
              <span class="icon"><img src="imagesHome/new/comunication.svg" alt="image"></span>
              <div class="section_title">
                <h2>Easy communication wherever you are live</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and types
                  etting industry lorem Ipsum has been the industrys standard dummy text ever since the when an unknown
                  printer took a galley of type and.</p>
              </div>
              <ul>
                <li data-aos="fade-up" data-aos-duration="2000">
                  <h3>Carefully designed</h3>
                  <p>Lorem Ipsum is simply dummy text of the printing and typ esetting industry lorem Ipsum has.</p>
                </li>
                <li data-aos="fade-up" data-aos-duration="2000">
                  <h3>Seamless Sync</h3>
                  <p>Simply dummy text of the printing and typesetting inustry lorem Ipsum has Lorem dollar summit.</p>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-6">
            <div class="communication_image" data-aos="fade-in" data-aos-duration="1000">
              <img data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100" class="moving_animation"
                src="imagesHome/new/cominication-data-03.png" alt="image">
              <img data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100" class="moving_animation"
                src="imagesHome/new/cominication-data-02.png" alt="image">
              <img data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100" class=""
                src="imagesHome/new/cominication-data-01.png" alt="image">
            </div>
          </div>
        </div>
      </div>
    </section> -->
    <!-- Communication Section End -->

    <!-- Powerful solution for your business Section Start -->
    <section class="powerful_solution" data-aos="fade-in" data-aos-duration="1000">
      <div class="dotes_anim_bloack">
        <div class="dots dotes_1"></div>
        <div class="dots dotes_2"></div>
        <div class="dots dotes_3"></div>
        <div class="dots dotes_4"></div>
        <div class="dots dotes_5"></div>
        <div class="dots dotes_6"></div>
        <div class="dots dotes_7"></div>
        <div class="dots dotes_8"></div>
      </div>
      <div class="bg_pattern">
        <img src="imagesHome/new/business_vectore.png" alt="image">
      </div>
      <div class="container">
        <div class="section_title" data-aos="fade-up" data-aos-duration="1000">
          <h2>Une solution puissante pour votre entreprise</h2>
          <p>Optimisez votre commerce électronique avec notre plateforme avancée de gestion de boutiques multicanaux. </p>


        </div>
        <div class="quality_lable" data-aos="fade-up" data-aos-duration="1000">
          <ul>
            <li>
              <p><i class="icofont-check-circled"></i>
               Hautement personnalisable</p>
            </li>
            <li>
              <p><i class="icofont-check-circled"></i>
                Design parfaitement adapté</p>
            </li>
            <li>
              <p><i class="icofont-check-circled"></i>
               Support mondial</p>
            </li>
          </ul>
        </div>
        <div class="counters_block" data-aos="fade-up" data-aos-duration="1000">
          <ul class="app_statstic" id="counter" data-aos="fade-in" data-aos-duration="1500">
            <li>
              <div class="text">
                <p><span class="counter-value" data-count="450">0</span><span>+</span></p>
                <p>Nombre de transactions financières</p>
              </div>
            </li>
            <li>
              <div class="text">
                <p><span class="counter-value" data-count="120">0 </span><span>+</span></p>
                <p>Nombre de boutiques connectées</p>
              </div>
            </li>
            <li>
              <div class="text">
                <p><span class="counter-value" data-count="135">1500</span><span>+</span></p>
                <p>Nombre de commandes traitées</p>
              </div>
            </li>
            <li>
              <div class="text">
                <p><span class="counter-value" data-count="324">0</span><span>+</span></p>
                <p>Nombre de fournisseurs gérés</p>
              </div>
            </li>
          </ul>
        </div>
        <div class="images_gallery_block row">
          <div class="gl_block col-md-3 col-sm-6" data-aos="fade-up" data-aos-duration="1000">
            <div class="img"><img src="imagesHome/new/Powerful-solution-01.png" alt="image"></div>
            <div class="img"><img src="imagesHome/new/Powerful-solution-02.png" alt="image"></div>
          </div>
          <div class="gl_block col-md-3 col-sm-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
            <div class="img"><img src="imagesHome/new/Powerful-solution-03.png" alt="image"></div>
            <div class="img"><img src="imagesHome/new/Powerful-solution-04.png" alt="image"></div>
            <div class="img"><img src="imagesHome/new/Powerful-solution-05.png" alt="image"></div>
          </div>
          <div class="gl_block col-md-3 col-sm-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="150">
            <div class="img"><img src="imagesHome/new/Powerful-solution-06.png" alt="image"></div>
            <div class="img"><img src="imagesHome/new/Powerful-solution-07.png" alt="image"></div>
          </div>
          <div class="gl_block col-md-3 col-sm-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            <div class="img"><img src="imagesHome/new/Powerful-solution-08.png" alt="image"></div>
            <div class="img"><img src="imagesHome/new/Powerful-solution-09.png" alt="image"></div>
          </div>
        </div>
      </div>
    </section>
    <!-- Powerful solution for your business Section End -->

    <!-- Easy integration Section Start -->
    <section class="row_am integration_section">
      <div class="container">
        <div class="section_title" data-aos="fade-up" data-aos-duration="1000">
          <h2>Intégration facile<br> avec les plateformes les plus courantes</h2>
          <p>Découvrez nos intégrations avec les plateformes leaders. 
            Simplifiez la gestion de votre commerce en ligne en connectant facilement votre boutique à ces outils essentiels.</p>
        </div>
        <div class="platforms_list">
          <div class="row">
              <!-- list Block Strat -->
            <div class="col-lg-2 col-md-3 col-6" data-aos="fade-up" data-aos-duration="1000">
              <div class="list_block">
                <div class="icon">
                  <img src="imagesHome/new/platforms_07.png" alt="image" >
                </div>
                <div class="caption">
                  <p>Wordpress</p>
                </div>
              </div>
            </div>
            <!-- list Block Strat -->
            <div class="col-lg-2 col-md-3 col-6" data-aos="fade-up" data-aos-duration="1000">
              <div class="list_block">
                <div class="icon">
                  <img src="imagesHome/new/platforms_10.png" alt="image" >
                </div>
                <div class="caption">
                  <p>Woocommerce </p>
                </div>
              </div>
            </div>
            <!-- list Block Strat -->
            <div class="col-lg-2 col-md-3 col-6" data-aos="fade-up" data-aos-duration="1000">
              <div class="list_block">
                <div class="icon">
                  <img src="imagesHome/new/platforms_08.png" alt="image" >
                </div>
                <div class="caption">
                  <p>Shopify</p>
                </div>
              </div>
            </div>
            <!-- list Block Strat -->
            <div class="col-lg-2 col-md-3 col-6" data-aos="fade-up" data-aos-duration="1000">
              <div class="list_block">
                <div class="icon">
                  <img src="imagesHome/new/platforms_02.png" alt="image" >
                </div>
                <div class="caption">
                  <p>Google Drive</p>
                </div>
              </div>
            </div>
            <!-- list Block Strat -->
            <div class="col-lg-2 col-md-3 col-6" data-aos="fade-up" data-aos-duration="1000">
              <div class="list_block">
                <div class="icon">
                  <img src="imagesHome/new/platforms_04.png" alt="image" >
                </div>
                <div class="caption">
                  <p>Mail</p>
                </div>
              </div>
            </div>
            <!-- list Block Strat -->
            <div class="col-lg-2 col-md-3 col-6" data-aos="fade-up" data-aos-duration="1000">
              <div class="list_block">
                <div class="icon">
                  <img src="imagesHome/new/platforms_05.jpg" alt="image" >
                </div>
                <div class="caption">
                  <p>Cloudinary</p>
                </div>
              </div>
            </div>
            <!-- list Block Strat -->
            <div class="col-lg-2 col-md-3 col-6" data-aos="fade-up" data-aos-duration="1000">
              <div class="list_block">
                <div class="icon">
                  <img src="imagesHome/new/platforms_11.png" alt="image" >
                </div>
                <div class="caption">
                  <p>Vonage</p>
                </div>
              </div>
            </div>
            <!-- list Block Strat -->
            <div class="col-lg-2 col-md-3 col-6" data-aos="fade-up" data-aos-duration="1000">
              <div class="list_block">
                <div class="icon">
                  <img src="imagesHome/new/platforms_03.png" alt="image" >
                </div>
                <div class="caption">
                  <p>Whatsapp</p>
                </div>
              </div>
            </div>
            <!-- list Block Strat -->
            <div class="col-lg-2 col-md-3 col-6" data-aos="fade-up" data-aos-duration="1000">
              <div class="list_block">
                <div class="icon">
                  <img src="imagesHome/new/platforms_01.png" alt="image" >
                </div>
                <div class="caption">
                  <p>Mailchimp</p>
                </div>
              </div>
            </div>
            <!-- list Block Strat -->
            <div class="col-lg-2 col-md-3 col-6" data-aos="fade-up" data-aos-duration="1000">
              <div class="list_block">
                <div class="icon">
                  <img src="imagesHome/new/platforms_02.png" alt="image" >
                </div>
                <div class="caption">
                  <p>Google Drive</p>
                </div>
              </div>
            </div>
            <!-- list Block Strat -->
            <div class="col-lg-2 col-md-3 col-6" data-aos="fade-up" data-aos-duration="1000">
              <div class="list_block">
                <div class="icon">
                  <img src="imagesHome/new/platforms_06.png" alt="image">
                </div>
                <div class="caption">
                  <p>Skype</p>
                </div>
              </div>
            </div>
            <!-- list Block Strat -->
            <div class="col-lg-2 col-md-3 col-6" data-aos="fade-up" data-aos-duration="1000">
              <div class="list_block">
                <div class="icon">
                  <img src="imagesHome/new/platforms_09.png" alt="image" >
                </div>
                <div class="caption">
                  <p>Firefox</p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- Easy integration Section End -->

    <!-- What our customer says Section Start -->
    <!-- <section class="customer_section">
      <div class="coustomer_block" data-aos="fade-up" data-aos-duration="1000">
        <div class="section_title" data-aos="fade-in" data-aos-duration="1000">
          <h2>Ce que disent nos clients</h2>
          <p>Lorem Ipsum is simply dummy text of the printing and typese tting indus orem Ipsum has beenthe standard
            dummy text ever since.</p>
        </div>
        <div id="coustomer_slider" class="owl-carousel owl-theme" data-aos="fade-in" data-aos-duration="1000">
          <div class="item">
            <div class="coustomer_slide_block">
              <div class="coustomer_img">
                <img src="imagesHome/new/testimonial-01.png" alt="image">
              </div>
              <div class="coustomer_review">
                <div class="rating">
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                </div>
                <p>Lorem Ipsum is simply dummy text of the print ing and typese tting us orem Ipsum has been lorem
                  beenthe standar ddummy Lorem Ipsum is simply mmy text of the print ing and typese tting us orem Ipsum
                  has lorem Ipsum has lorem beenthe standar ddummy. </p>
                <h3 class="coustomer_name">Shayna John</h3>
                <span class="desiganation">Careative inc</span>
              </div>
            </div>
          </div>

          <div class="item">
            <div class="coustomer_slide_block">
              <div class="coustomer_img">
                <img src="imagesHome/new/testimonial-02.png" alt="image">
              </div>
              <div class="coustomer_review">
                <div class="rating">
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                </div>
                <p>Lorem Ipsum is simply dummy text of the print ing and typese tting us orem Ipsum has been lorem
                  beenthe standar ddummy Lorem Ipsum is simply mmy text of the print ing and typese tting us orem Ipsum
                  has lorem Ipsum has lorem beenthe standar ddummy. </p>
                <h3 class="coustomer_name">Wilium Smith</h3>
                <span class="desiganation">Fish Kreativ</span>
              </div>
            </div>
          </div>

          <div class="item">
            <div class="coustomer_slide_block">
              <div class="coustomer_img">
                <img src="imagesHome/new/testimonial-03.png" alt="image">
              </div>
              <div class="coustomer_review">
                <div class="rating">
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                </div>
                <p>Lorem Ipsum is simply dummy text of the print ing and typese tting us orem Ipsum has been lorem
                  beenthe standar ddummy Lorem Ipsum is simply mmy text of the print ing and typese tting us orem Ipsum
                  has lorem Ipsum has lorem beenthe standar ddummy. </p>
                <h3 class="coustomer_name">John Doe</h3>
                <span class="desiganation">Digital People</span>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="review_summery" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
        <div class="rating">
          <span><i class="icofont-star"></i></span>
          <span><i class="icofont-star"></i></span>
          <span><i class="icofont-star"></i></span>
          <span><i class="icofont-star"></i></span>
          <span><i class="icofont-star"></i></span>
        </div>
        <p><span>5.0 / 5.0 -</span> <a href="testimonial.html">3689 Total User Reviews <i class="icofont-arrow-right"></i></a></p>
      </div>
    </section> -->

    <!-- Trusted Section start -->
    <section class="row_am trusted_section">
      <!-- container start -->
      <div class="container">
        <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
          <h2>Plus de <span>150+</span> entreprises nous font confiance</h2>
          <p>Découvrez notre réseau de partenaires de confiance.Explorez nos partenariats </br> solides et bénéficiez d'une
            expertise diversifiée pour votre entreprise.</p>
        </div>
        <!-- logos slider start -->
        <div class="company_logos" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
          <div id="company_slider" class="owl-carousel owl-theme">
            <div class="item">
              <div class="logo">
                <img src="imagesHome/paypal.png" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="logo">
                <img src="imagesHome/spoty.png" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="logo">
                <img src="imagesHome/shopboat.png" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="logo">
                <img src="imagesHome/slack.png" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="logo">
                <img src="imagesHome/envato.png" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="logo">
                <img src="imagesHome/paypal.png" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="logo">
                <img src="imagesHome/spoty.png" alt="image">
              </div>
            </div>
            <div class="item">
              <div class="logo">
                <img src="imagesHome/shopboat.png" alt="image">
              </div>
            </div>
          </div>
        </div>
        <!-- logos slider end -->
      </div>
      <!-- container end -->
    </section>
    <!-- Trusted Section ends -->

    <!-- Pricing-Section -->
    <section class="row_am pricing_section" id="pricing" data-aos="fade-in" data-aos-duration="1000">
      <!-- container start -->
      <div class="container">
        <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
          <h2>Meilleurs plans, payez ce que vous utilisez</h2>
          <p>Découvrez nos tarifs flexibles et transparents. Payez uniquement ce que vous utilisez, sans frais cachés </br>ni engagements à long terme. 
             Choisissez le plan qui correspond le mieux à vos besoins et faites évoluer </br> votre abonnement en fonction de votre croissance.</p>
        </div>
        <!-- toggle button -->
        <div class="toggle_block" data-aos="fade-up" data-aos-duration="1500">
          <span class="month active">Mensuel</span>
          <div class="tog_block">
            <span class="tog_btn"></span>
          </div>
          <span class="years">Annuel</span>
          <span class="offer">50% de réduction</span>
        </div>

        <!-- pricing box  monthly start -->
        <div class="pricing_pannel monthly_plan active" data-aos="fade-up" data-aos-duration="1500">
          <!-- row start -->
          <div class="row">
            <!-- pricing box 1 -->
            <div class="col-md-4">
              <div class="pricing_block">
                <div class="icon">
                  <img src="imagesHome/new/Free-Trial-01.svg" alt="image">
                  <div class="dot_block">
                    <span class="dot_anim"></span>
                    <span class="dot_anim"></span>
                    <span class="dot_anim"></span>
                  </div>
                </div>
                <div class="pkg_name">
                  <h3>Essai gratuit</h3>
                  <span>Pour l'essentiel</span>
                </div>
                <span class="price">0DH<span>/Mois</span></span>
                <ul class="benifits">
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>7 jours d'essai gratuit</p>
                  </li>
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>2 boutiques au choix</p>
                  </li>
                  <!-- <li class="include">
                    <p><i class="icofont-check-circled"></i>10 Go d'hébergement dédié gratuit</p>
                  </li> -->
                  <li class="exclude">
                    <p><i class="icofont-close-circled"></i>Mises à jour illimitées</p>
                  </li>
                  <li class="exclude">
                    <p><i class="icofont-close-circled"></i>Support en direct</p>
                  </li>
                </ul>
                <a href="#" class="btn btn_main">S'abonner<i class="icofont-arrow-right"></i></a>
              </div>
            </div>

            <!-- pricing box 2 -->
            <div class="col-md-4">
              <div class="pricing_block highlited_block">
                <div class="icon">
                  <img src="imagesHome/new/unlimited.png" alt="image">
                  <div class="dot_block">
                    <span class="dot_anim"></span>
                    <span class="dot_anim"></span>
                    <span class="dot_anim"></span>
                  </div>
                </div>
                <div class="pkg_name">
                  <h3>Illimité</h3>
                  <span>Pour les professionnels</span>
                </div>
                <span class="price">99DH<span>/Mois</span></span>
                <ul class="benifits">
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>7 jours d'essai gratuit</p>
                  </li>
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>100 boutiques au choix</p>
                  </li>
                  <!-- <li class="include">
                    <p><i class="icofont-check-circled"></i>10 GB Dedicated Hosting free</p>
                  </li> -->
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>Mises à jour illimitées</p>
                  </li>
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>Support en direct</p>
                  </li>
                </ul>
                <a href="#" class="btn btn_main">S'abonner <i class="icofont-arrow-right"></i></a>
              </div>
            </div>

            <!-- pricing box 3 -->
            <div class="col-md-4">
              <div class="pricing_block">
                <div class="icon">
                  <img src="imagesHome/new/Premium.svg" alt="image">
                  <div class="dot_block">
                    <span class="dot_anim"></span>
                    <span class="dot_anim"></span>
                    <span class="dot_anim"></span>
                  </div>
                </div>
                <div class="pkg_name">
                  <h3>Premium</h3>
                  <span>Pour une petite équipe</span>
                </div>
                <span class="price">55DH<span>/Mois</span></span>
                <ul class="benifits">
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>7 jours d'essai gratuit</p>
                  </li>
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>25 boutiques au choix</p>
                  </li>
                  <!-- <li class="include">
                    <p><i class="icofont-check-circled"></i>10 GB Dedicated Hosting free</p>
                  </li> -->
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>Mises à jour illimitées</p>
                  </li>
                  <li class="exclude">
                    <p><i class="icofont-close-circled"></i>Support en direct</p>
                  </li>
                </ul>
                <a href="#" class="btn btn_main">S'abonner <i class="icofont-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <!-- row end -->
        </div>
        <!-- pricing box monthly end -->

        <!-- pricing box yearly start -->
        <div class="pricing_pannel yearly_plan" data-aos="fade-up" data-aos-duration="1500">
          <div class="row">

            <!-- pricing box 1 -->
            <div class="col-md-4">
              <div class="pricing_block">
                <div class="icon">
                  <img src="imagesHome/new/Free-Trial-01.svg" alt="image">
                  <div class="dot_block">
                    <span class="dot_anim"></span>
                    <span class="dot_anim"></span>
                    <span class="dot_anim"></span>
                  </div>
                </div>
                <div class="pkg_name">
                  <h3>Essai gratuit</h3>
                  <span>Pour l'essentiel</span>
                </div>
                <span class="price">0DH<span>/Année</span></span>
                <ul class="benifits">
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>7 jours d'essai gratuit</p>
                  </li>
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>2 boutiques au choix</p>
                  </li>
                  <!-- <li class="include">
                    <p><i class="icofont-check-circled"></i>10 Go d'hébergement dédié gratuit</p>
                  </li> -->
                  <li class="exclude">
                    <p><i class="icofont-close-circled"></i>Mises à jour illimitées</p>
                  </li>
                  <li class="exclude">
                    <p><i class="icofont-close-circled"></i>Support en direct</p>
                  </li>
                </ul>
                <a href="#" class="btn btn_main">S'abonner<i class="icofont-arrow-right"></i></a>
              </div>
            </div>

            <!-- pricing box 2 -->
            <div class="col-md-4">
              <div class="pricing_block highlited_block">
                <div class="icon">
                  <img src="imagesHome/new/unlimited.png" alt="image">
                  <div class="dot_block">
                    <span class="dot_anim"></span>
                    <span class="dot_anim"></span>
                    <span class="dot_anim"></span>
                  </div>
                </div>
                <div class="pkg_name">
                  <h3>Illimité</h3>
                  <span>Pour les professionnels</span>
                </div>
                <span class="price">999DH<span>/Année</span></span>
                <ul class="benifits">
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>7 jours d'essai gratuit</p>
                  </li>
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>100 boutiques au choix</p>
                  </li>
                  <!-- <li class="include">
                    <p><i class="icofont-check-circled"></i>10 GB Dedicated Hosting free</p>
                  </li> -->
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>Mises à jour illimitées</p>
                  </li>
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>Support en direct</p>
                  </li>
                </ul>
                <a href="#" class="btn btn_main">S'abonner <i class="icofont-arrow-right"></i></a>
              </div>
            </div>

            <!-- pricing box 3 -->
            <div class="col-md-4">
              <div class="pricing_block">
                <div class="icon">
                  <img src="imagesHome/new/Premium.svg" alt="image">
                  <div class="dot_block">
                    <span class="dot_anim"></span>
                    <span class="dot_anim"></span>
                    <span class="dot_anim"></span>
                  </div>
                </div>
                <div class="pkg_name">
                  <h3>Premium</h3>
                  <span>Pour une petite équipe</span>
                </div>
                <span class="price">555DH<span>/Année</span></span>
                <ul class="benifits">
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>7 jours d'essai gratuit</p>
                  </li>
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>25 boutiques au choix</p>
                  </li>
                  <!-- <li class="include">
                    <p><i class="icofont-check-circled"></i>10 GB Dedicated Hosting free</p>
                  </li> -->
                  <li class="include">
                    <p><i class="icofont-check-circled"></i>Mises à jour illimitées</p>
                  </li>
                  <li class="exclude">
                    <p><i class="icofont-close-circled"></i>Support en direct</p>
                  </li>
                </ul>
                <a href="#" class="btn btn_main">S'abonner <i class="icofont-arrow-right"></i></a>
              </div>
            </div>

          </div>
        </div>
      </div>
      <!-- container start end -->
    </section>
    <!-- Pricing-Section end -->

    <!-- Need support Section Start -->
    <section class="need_section" data-aos="fade-in" data-aos-duration="1500" data-aos-delay="100">
      <div class="container">
        <div class="need_block">
          <div class="need_text">
            <div class="section_title">
              <h2>Besoin d'aide ? contactez notre équipe</h2>
              <p><i class="icofont-clock-time"></i> Du lundi au vendredi : de 9 heures à 18 heures</p>
            </div>
          </div>
          <div class="need_action">
            <a href="tel:1234567899" class="btn"><i class="icofont-phone-circle"></i>  +212-522-507-014</a>
            <a href="#faqBlock" class="faq_btn">Lire la FAQ </a>
          </div>
        </div>
      </div>
    </section>
    <!-- Need support Section End -->

    <!-- Interface overview-Section start -->
    <!-- <section class="row_am interface_section">
      <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
        <h2>Interface overview</h2>
        <p>
          Lorem Ipsum is simply dummy text of the printing and typese tting indus orem Ipsum has beenthe standard
          dummy text ever since.
        </p>
      </div>
      <div class="screen_slider" data-aos="fade-in" data-aos-duration="1500" data-aos-delay="100">
        <div id="screen_slider" class="owl-carousel owl-theme">
          <div class="item">
            <div class="screen_frame_img">
              <img src="imagesHome/new/Interface-overview-01.png" alt="image">
              <h3 class="caption">Report Page</h3>
            </div>
          </div>
          <div class="item">
            <div class="screen_frame_img">
              <img src="imagesHome/new/Interface-overview-02.png" alt="image">
              <h3 class="caption">Dashboard</h3>
            </div>
          </div>
          <div class="item">
            <div class="screen_frame_img">
              <img src="imagesHome/new/Interface-overview-03.png" alt="image">
              <h3 class="caption">Report Page</h3>
            </div>
          </div>
          <div class="item">
            <div class="screen_frame_img">
              <img src="imagesHome/new/Interface-overview-02.png" alt="image">
              <h3 class="caption">Dashboard</h3>
            </div>
          </div>
          <div class="item">
            <div class="screen_frame_img">
              <img src="imagesHome/new/Interface-overview-01.png" alt="image">
              <h3 class="caption">Report Page</h3>
            </div>
          </div>
          <div class="item">
            <div class="screen_frame_img">
              <img src="imagesHome/new/Interface-overview-03.png" alt="image">
              <h3 class="caption">Report Page</h3>
            </div>
          </div>
        </div>
      </div>
    </section> -->
    <!-- Interface overview-Section end -->

    <!-- Start Your Free Trial Section Start -->
    <!-- <section class="free_trial_section" data-aos="fade-in" data-aos-duration="1500">
      <div class="free_inner">
        <div class="text">
          <div class="section_title" data-aos="fade-up" data-aos-duration="1500">
            <h2>Start Your 14-Day Free Trial</h2>
            <p>Instant free download from apple and play store orem Ipsum is simply dummy
              text of the printing.</p>
          </div>
          <ul data-aos="fade-up" data-aos-duration="1500">
            <li>
              <p><i class="icofont-check-circled"></i>Free 14-day trial</p>
            </li>
            <li>
              <p><i class="icofont-check-circled"></i>No credit card required</p>
            </li>
            <li>
              <p><i class="icofont-check-circled"></i>Support 24/7</p>
            </li>
            <li>
              <p><i class="icofont-check-circled"></i>Cancel anytime</p>
            </li>
          </ul>
          <div class="start_and_watch" data-aos="fade-up" data-aos-duration="1500">
            <a href="contact-us.html" class="btn btn_main">GET STARTED <i class="icofont-arrow-right"></i></a>
            <a class="popup-youtube play-button" data-url="https://www.youtube.com/embed/tgbNymZ7vqY?autoplay=1&mute=1"
              data-toggle="modal" data-target="#myModal" title="XJj2PbenIsU">
              <div class="play_btn">
                <img src="imagesHome/play_icon.png" alt="image">
                <div class="waves-block">
                  <div class="waves wave-1"></div>
                  <div class="waves wave-2"></div>
                  <div class="waves wave-3"></div>
                </div>
              </div>
              <span>WATCH PROMO</span>
            </a>
          </div>
        </div>
        <div class="side_img">
          <img src="imagesHome/new/start-free-side-img.png" alt="image">
        </div>
      </div>
    </section> -->
    <!-- Start Your Free Trial Section End -->

    <!-- FAQ-Section start -->
    <section id="faqBlock" class="row_am faq_section">
      <!-- container start -->
      <div class="container">
        <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
          <!-- h2 -->
          <h2><span>FAQ</span> - Foire aux questions</h2>
          <!-- p -->
          <p>Explorez notre FAQ pour trouver des réponses à vos questions les plus fréquentes.
            </br> Nous sommes là pour vous aider à obtenir toutes les informations dont vous avez besoin </br> 
            pour tirer le meilleur parti de notre service.</p>
        </div>
        <!-- faq data -->
        <div class="faq_panel">
          <div class="accordion" id="accordionExample">
            <div class="card" data-aos="fade-up" data-aos-duration="1500">
              <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                  <button type="button" class="btn btn-link active" data-toggle="collapse" data-target="#collapseOne">
                    <i class="icon_faq icofont-plus"></i> Comment puis-je payer ?</button>
                </h2>
              </div>
              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem Ipsum has. been the
                    industrys standard dummy text ever since the when an unknown printer took a galley of type and
                    scrambled it to make a type specimen book. It has survived not only five cen turies but also the
                    leap into electronic typesetting, remaining essentially unchanged.</p>
                </div>
              </div>
            </div>
            <div class="card" data-aos="fade-up" data-aos-duration="1500">
              <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                  <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                    data-target="#collapseTwo"><i class="icon_faq icofont-plus"></i> Comment créer un compte ?</button>
                </h2>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem Ipsum has. been the
                    industrys standard dummy text ever since the when an unknown printer took a galley of type and
                    scrambled it to make a type specimen book. It has survived not only five cen turies but also the
                    leap into electronic typesetting, remaining essentially unchanged.</p>
                </div>
              </div>
            </div>
            <div class="card" data-aos="fade-up" data-aos-duration="1500">
              <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                  <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                    data-target="#collapseThree"><i class="icon_faq icofont-plus"></i>Quelle est la procédure à suivre pour obtenir un remboursement
                    ?</button>
                </h2>
              </div>
              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem Ipsum has. been the
                    industrys standard dummy text ever since the when an unknown printer took a galley of type and
                    scrambled it to make a type specimen book. It has survived not only five cen turies but also the
                    leap into electronic typesetting, remaining essentially unchanged.</p>
                </div>
              </div>
            </div>
            <div class="card" data-aos="fade-up" data-aos-duration="1500">
              <div class="card-header" id="headingFour">
                <h2 class="mb-0">
                  <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                    data-target="#collapseFour"><i class="icon_faq icofont-plus"></i>Combien de comptes pourrai-je creer
                    ?</button>
                </h2>
              </div>
              <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                <div class="card-body">
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem Ipsum has. been the
                    industrys standard dummy text ever since the when an unknown printer took a galley of type and
                    scrambled it to make a type specimen book. It has survived not only five cen turies but also the
                    leap into electronic typesetting, remaining essentially unchanged.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- container end -->
    </section>
    <!-- FAQ-Section end -->

    <!-- Story-Section-Start -->
    <!-- <section class="row_am latest_story" id="blog">
      <div class="container">
        <div class="section_title" data-aos="fade-in" data-aos-duration="1500" data-aos-delay="100">
          <h2>Read latest <span>story</span></h2>
          <p>Lorem Ipsum is simply dummy text of the printing and typese tting <br> indus orem Ipsum has beenthe
            standard dummy.</p>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="story_box" data-aos="fade-up" data-aos-duration="1500">
              <div class="story_img">
                <img src="imagesHome/new/story-01.png" alt="image">
                <span><span>23</span> AUG</span>
              </div>
              <div class="story_text">
                <div class="statstic">
                  <span><i class="icofont-user-suited"></i> Admin</span>
                  <span><i class="icofont-speech-comments"></i> 36 Comments</span>
                </div>
                <h3>Powerfull features makes
                  software awesome !</h3>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry lorem Ipsum has been.</p>
                <a href="blog-detail.html" class="btn text_btn">READ MORE <i class="icofont-arrow-right"></i></a>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="story_box" data-aos="fade-up" data-aos-duration="1500">
              <div class="story_img">
                <img src="imagesHome/new/story-02.png" alt="image">
                <span><span>18</span> AUG</span>
              </div>
              <div class="story_text">
                <div class="statstic">
                  <span><i class="icofont-user-suited"></i> Admin</span>
                  <span><i class="icofont-speech-comments"></i> 36 Comments</span>
                </div>
                <h3>Why software is globally used as best software</h3>
                <p>Simply dummy text of the printing and typesetting industry lorem Ipsum has Lorem Ipsum is.</p>
                <a href="blog-detail.html" class="btn text_btn">READ MORE <i class="icofont-arrow-right"></i></a>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="story_box" data-aos="fade-up" data-aos-duration="1500">
              <div class="story_img">
                <img src="imagesHome/new/story-03.png" alt="image">
                <span><span>9</span> AUG</span>
              </div>
              <div class="story_text">
                <div class="statstic">
                  <span><i class="icofont-user-suited"></i> Admin</span>
                  <span><i class="icofont-speech-comments"></i> 36 Comments</span>
                </div>
                <h3>Beautiful user interface with bug free code.</h3>
                <p>Printing and typesetting industry lorem Ipsum has Lorem simply dummy text of the.</p>
                <a href="blog-detail.html" class="btn text_btn">READ MORE <i class="icofont-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->
    <!-- Story-Section-end -->

    <!-- Footer-Section start -->
    <footer>
      <div class="top_footer" id="contact">
        <!-- container start -->
        <div class="container">
          <!-- row start -->
          <div class="row">
            <!-- footer link 1 -->
            <div class="col-lg-4 col-md-6 col-12">
              <div class="abt_side">
                <div class="logo"> <img src="imagesHome/new/Logo.png" alt="image"></div>
                <p>Notre plateforme offre une solution innovante pour vous, 
                  en vous fournissant un outil puissant pour gérer efficacement leurs activités sur plusieurs canaux de vente. </p>
                <div class="news_letter_block">
                  <form action="https://kalanidhithemes.com/live-preview/landing-page/codely/all-demo/01-codely-landing-page-defoult/submit">
                    <div class="form-group">
                      <input type="email" placeholder="Entrer votre e-mail" class="form-control">
                      <button class="btn"><i class="icofont-paper-plane"></i></button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- footer link 2 -->
            <div class="col-lg-2 col-md-6 col-12">
              <div class="links">
                <h3>Liens utiles</h3>
                <ul>
                  <li><a href="index.html">Accueil</a></li>
                  <li><a href="about-us.html">A propos de nous</a></li>
                  <li><a href="service-list-1.html">Services</a></li>
                  {{-- <li><a href="service-detail.html">Service Detail</a></li>
                  <li><a href="blog-list.html">Blog</a></li> --}}
                </ul>
              </div>
            </div>

            <!-- footer link 3 -->
            <div class="col-lg-3 col-md-6 col-12">
              <div class="links">
                <h3>Aide & Support</h3>
                <ul>
                  <li><a href="contact-us.html">Contact</a></li>
                  <li><a href="faq.html">FAQs</a></li>
                  <li><a href="#">Comment ça marche ?</a></li>
                  <li><a href="#">Termes et conditions</a></li>
                  <li><a href="#">Politique de confidentialité</a></li>
                </ul>
              </div>
            </div>

            <!-- footer link 4 -->
            <div class="col-lg-3 col-md-6 col-12">
              <div class="try_out">
                <h3>Contactez nous</h3>
                <ul>
                  <li>
                    <span class="icon">
                      <img src="imagesHome/new/contact_01.png" alt="image">
                    </span>
                    <div class="text">
                      <p>Nous contacter <br>241, Boulevard Emile Zola, etg 5, 20082 Casablanca</p>
                    </div>
                  </li>
                  <li>
                    <span class="icon">
                      <img src="imagesHome/new/contact_02.png" alt="image">
                    </span>
                    <div class="text">
                      <p>Appelez-nous <a href="tel:+1-900-1234567">+212-522-507-014</a></p>
                    </div>
                  </li>
                  <li>
                    <span class="icon">
                      <img src="imagesHome/new/contact_03.png" alt="image">
                    </span>
                    <div class="text">
                      <p>Envoyez-nous un e-mail <a href="mailto:support@example.com">contact@gtel-dev.com</a></p>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <!-- row end -->
        </div>
        <!-- container end -->
      </div>

      <!-- last footer -->
      <div class="bottom_footer">
        <!-- container start -->
        <div class="container">
          <!-- row start -->
          <div class="row">
            <div class="col-md-4">
              <p>© Droits d'auteur 2023. Tous droits réservés.</p>
            </div>
            <div class="col-md-4">
              <ul class="social_media">
                <li><a href="#"><i class="icofont-facebook"></i></a></li>
                <li><a href="#"><i class="icofont-twitter"></i></a></li>
                <li><a href="#"><i class="icofont-instagram"></i></a></li>
                <li><a href="#"><i class="icofont-pinterest"></i></a></li>
              </ul>
            </div>
            {{-- <div class="col-md-4">
              <p class="developer_text">Design & developed by <a href="https://themeforest.net/user/kalanidhithemes" target="blank">Kalanidhi Themes</a></p>
            </div> --}}
          </div>
          <!-- row end -->
        </div>
        <!-- container end -->
      </div>

      <!-- go top button -->
      <div class="go_top" id="Gotop">
        <span><i class="icofont-arrow-up"></i></span>
      </div>
    </footer>
    <!-- Footer-Section end -->

    <!-- VIDEO MODAL -->
    <div class="modal fade youtube-video" id="myModal" tabindex="-1" role="dialog" >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <button id="close-video" type="button" class="button btn btn-default text-right" data-dismiss="modal">
            <i class="icofont-close-line-circled"></i>
          </button>
          <div class="modal-body">
            <div id="video-container" class="video-container">
              <iframe id="youtubevideo" width="640" height="360" allowfullscreen></iframe>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- Page-wrapper-End -->

  <!-- owl-js-Link -->
  <script src="jsHome/owl.carousel.min.js"></script>
  <!-- bootstrap-js-Link -->
  <script src="jsHome/bootstrap.min.js"></script>
  <!-- aos-js-Link -->
  <script src="jsHome/aos.js"></script>
  <!-- main-js-Link -->
  <script src="jsHome/main.js"></script>


</body>


<!-- Mirrored from kalanidhithemes.com/live-preview/landing-page/codely/all-demo/01-codely-landing-page-defoult/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 09 Jan 2024 10:28:50 GMT -->
</html>