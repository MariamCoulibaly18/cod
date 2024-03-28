$(function () {
    "use strict";
  
    // Fonction pour mettre en surbrillance l'élément actif dans la barre latérale
    function highlightActiveSidebarLink() {
      const currentPath = window.location.pathname;
      const sidebarLinks = $("ul#sidebarnav a.sidebar-link");
  
      sidebarLinks.each(function () {
        const link = $(this);
        const linkPath = link.attr("href");
  
        // Comparaison de l'URL actuelle avec les liens de la barre latérale
        if (currentPath === linkPath) {
          link.addClass("active");
  
          // Si c'est un sous-menu, assurez-vous que son parent est également marqué comme actif
          if (link.closest(".sub-menu").length > 0) {
            link.closest(".sidebar-item").addClass("active");
          }
        }
      });
    }
  
    // Appel de la fonction pour mettre en surbrillance l'élément actif au chargement de la page
    highlightActiveSidebarLink();
  
    // Gestionnaire d'événement pour les clics sur les liens de la barre latérale
    $("#sidebarnav a.sidebar-link").on("click", function () {
      // Réinitialiser toutes les classes "active"
      $("#sidebarnav a.sidebar-link").removeClass("active");
      $(".sidebar-item").removeClass("active");
  
      // Mettre en surbrillance l'élément actuel
      $(this).addClass("active");
      if ($(this).closest(".sub-menu").length > 0) {
        $(this).closest(".sidebar-item").addClass("active");
      }
    });
  });
  