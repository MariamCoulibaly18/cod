<?php

namespace App\Http\Controllers\API\Local;

use App\Models\Produit;
use App\Models\Boutique;
use App\Models\Commande;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Models\CommandeProduit;
use App\Http\Controllers\Controller;
use DateTime;
use DateInterval;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function produitVendus($store)
    {
        //
        $boutique = Boutique::where('id', $store)->with('clients.commandes.produits')->with('clients.commandes.statutLivraison')->firstOrFail();
        $clients = $boutique->clients;
        $produits = [];

        foreach ($clients as $client) {
            $orders = $client->commandes()->where('status', 'completed')->get();
            // dd($orders);
            foreach ($orders as $order) {
                $line_items = CommandeProduit::where('commande_id', $order->id)->with('produit')->with('produit.categories')->get();
                // dd($line_items);
                // dd($line_items);
                foreach ($line_items as $item) {
                    $product_id = $item->produit->id;
                    $quantity = $item->quantite;
                    $categories = $item->produit->categories;
                    if (isset($produits[$product_id])) {
                        $produits[$product_id]['count']+= $quantity;
                     } else {
                                 $produits[$product_id] = [
                                    'product_id' => $product_id,
                                    'name' => $item->produit->nom,
                                    'price'=>$item->prix,
                                    'count' =>  $quantity,
                                    'categories' => $categories->map(function ($item, $key) {
                                        return [
                                            'id' => $item['id'],
                                            'name' => $item['nom'],
                                        ];
                                    }),
                                ];

                            }
                 }
            }
        }
         $produits_repetes = array_filter($produits, function ($product) {
                return $product['count'] > 1;
            });
         usort($produits_repetes, function ($a, $b) {
             return $b['count'] - $a['count'];
         });
        $top_10_produits = array_slice($produits_repetes, 0, 10);
        return response()->json(['produits' => $top_10_produits], 200);
    }
    function commandes($store)
    {
        // Récupérez les informations de la boutique
        $boutique = Boutique::where('id', $store)->first();    
        // Récupérez le nombre total de commandes
        $commandes = Commande::with('client')->with('produits')->get();
        $nombreTotalDeCommandes = count($commandes);
        $dateActuelle = new DateTime();
        $dateDebutAnneeEnCours = new DateTime(date('Y-01-01'));
       
        // Format des dates pour la requête WooCommerce
        $formatDate = 'Y-m-d';
        // Tableaux pour stocker le nombre de commandes par année
        $commandesParAnnee = [];
        $commandesParAnneeDerniere = [];
        // Format des dates pour la requête WooCommerce
        while ($dateDebutAnneeEnCours <= $dateActuelle) {
            $dateDebutStr = $dateDebutAnneeEnCours->format($formatDate);
    
            // Dates de fin (un mois plus tard)
            $dateFinAnneeEnCours = clone $dateDebutAnneeEnCours;
            $dateFinAnneeEnCours->add(new DateInterval('P1M'));
            $dateFinStrAnneeEnCours = $dateFinAnneeEnCours->format($formatDate);
    
            // Parcourez les commandes pour compter celles qui correspondent à cette période (année en cours)
            $commandesPourAnneeEnCours = 0;
            foreach ($commandes as $commande) {
                $dateCommande = substr($commande->created_at, 0, 10); // Prend seulement la partie date (sans l'heure)
                if ($dateCommande >= $dateDebutStr && $dateCommande < $dateFinStrAnneeEnCours) {
                    $commandesPourAnneeEnCours++;
                }
            }
    
            // Parcourez les commandes pour compter celles qui correspondent à cette période (année précédente)
            // $commandesPourAnneePrecedente = 0;
            // foreach ($commandes as $commande) {
            //     $dateCommande = substr($commande->created_at, 0, 10);
            //     if ($dateCommande >= $dateDebutStr && $dateCommande < $dateFinStrAnneePrecedente) {
            //         $commandesPourAnneePrecedente++;
            //     }
            // }        
            // Créez un tableau associatif avec les champs date, nombreCommande et pourcentage pour chaque année
            $commandesParAnnee[] = [
                'dateDebut' => $dateDebutAnneeEnCours->format('F'),
                'dateFin' => $dateFinAnneeEnCours->format('F'),   
                'nombreDeCommandes' => $commandesPourAnneeEnCours,
            ];
    
            // $commandesParAnneeDerniere[] = [
            //     'dateDebut' => $dateDebutAnneePrecedente->format('F'), 
            //     'dateFin' => $dateFinAnneePrecedente->format('F'),     
            //     'nombreDeCommandes' => $commandesPourAnneePrecedente,
            // ];
    
            // Avancez d'un mois dans la boucle pour les deux années
            $dateDebutAnneeEnCours->add(new DateInterval('P1M'));
            // $dateDebutAnneePrecedente->add(new DateInterval('P1M'));
        }
        $dateDebutAnneePrecedente = (new DateTime())->sub(new DateInterval('P1Y'));
        $dateDebutAnneePrecedente->setDate($dateDebutAnneePrecedente->format('Y'), 1, 1);
        while ($dateDebutAnneePrecedente <= $dateActuelle) {
            $dateDebutStr = $dateDebutAnneePrecedente->format($formatDate);
    
            $dateFinAnneePrecedente = clone $dateDebutAnneePrecedente;
            $dateFinAnneePrecedente->add(new DateInterval('P1M'));
            $dateFinStrAnneePrecedente = $dateFinAnneePrecedente->format($formatDate);
    
            // Parcourez les commandes pour compter celles qui correspondent à cette période (année précédente)
            $commandesPourAnneePrecedente = 0;
            foreach ($commandes as $commande) {
                $dateCommande = substr($commande->created_at, 0, 10);
                if ($dateCommande >= $dateDebutStr && $dateCommande < $dateFinStrAnneePrecedente) {
                    $commandesPourAnneePrecedente++;
                }
            }        
            $commandesParAnneeDerniere[] = [
                'dateDebut' => $dateDebutAnneePrecedente->format('F'), 
                'dateFin' => $dateFinAnneePrecedente->format('F'),     
                'nombreDeCommandes' => $commandesPourAnneePrecedente,
            ];
    
            // Avancez d'un mois dans la boucle pour les deux années
            $dateDebutAnneePrecedente->add(new DateInterval('P1M'));
        }
        return response()->json([
            'commandesParAnnee' => $commandesParAnnee,
            'commandesParAnneeDerniere' => $commandesParAnneeDerniere,
            'nombreTotalDeCommandes' => $nombreTotalDeCommandes
        ], 200);
    }
    public function ventes($store)
    {
        $boutique = Boutique::where('id', $store)->with('clients.commandes.produits')->with('clients.commandes.statutLivraison')->firstOrFail();
        $clients = $boutique->clients;
         // Prix total de vente de toutes les commandes de l'année en cours
         $totalVentes = 0;
    
         // Prix total de vente de toutes les commandes de l'année précédente
         $totalVentesAnneePrecedente = 0;
     
         // Tableau pour stocker le total de ventes par mois de l'année en cours
         $ventesParMois = [];
     
         // Tableau pour stocker le total de ventes par mois de l'année précédente
         $ventesParMoisAnneePrecedente = [];
     
         $currentYear = date('Y');
         $lastYear = $currentYear - 1;
        $orders =Commande::with('client')->where('status', 'completed')->get();
            foreach ($orders as $order) {
                $prix = $order->total;
                $date = new DateTime($order->created_at);
                $year = $date->format('Y');
        
                // Ajouter le prix de la commande au total des ventes de l'année en cours
                if ($year == $currentYear) {
                    $totalVentes += $prix;
                }
                 // Ajouter le prix de la commande au total des ventes de l'année précédente
                elseif ($year == $lastYear) {
                    $totalVentesAnneePrecedente += $prix;
                }
                // Extraire le mois et l'année de la date
                $moisAnnee = $date->format('Y-m');
        
                // Si l'entrée pour ce mois n'existe pas dans le tableau de l'année en cours, l'initialiser à 0
                if ($year == $currentYear && !isset($ventesParMois[$moisAnnee])) {
                    $ventesParMois[$moisAnnee] = 0;
                }
                 // Si l'entrée pour ce mois n'existe pas dans le tableau de l'année précédente, l'initialiser à 0
                elseif ($year == $lastYear && !isset($ventesParMoisAnneePrecedente[$moisAnnee])) {
                    $ventesParMoisAnneePrecedente[$moisAnnee] = 0;
                }
                // Ajouter le prix de la commande aux ventes mensuelles de l'année en cours
                if ($year == $currentYear) {
                    $ventesParMois[$moisAnnee] += $prix;
                }
                // Ajouter le prix de la commande aux ventes mensuelles de l'année précédente
                elseif ($year == $lastYear) {
                    $ventesParMoisAnneePrecedente[$moisAnnee] += $prix;
                }
            }
        // Transformer le tableau de l'année en cours en un format souhaité avec les mois au format texte
        $ventesParMoisFormatted = [];
        // Obtenez le mois actuel
        $currentMonth = date('m');

        // Boucle à travers les mois depuis le début de l'année jusqu'au mois actuel
        for ($mois = 1; $mois <= $currentMonth; $mois++) {
            $moisAnnee = $currentYear . '-' . str_pad($mois, 2, '0', STR_PAD_LEFT); // Format 'Y-m'
            $moisTexte = DateTime::createFromFormat('!m', $mois)->format('F'); // 'F' donne le nom complet du mois

            $ventesParMoisFormatted[] = [
                'mois' => $moisTexte,
                'totalVente' => $ventesParMois[$moisAnnee] ?? 0,
            ];
        }
        // Transformer le tableau de l'année précédente en un format souhaité avec les mois au format texte
        $ventesParMoisAnneePrecedenteFormatted = [];
        for ($mois = 1; $mois <= 12; $mois++) {
            $moisAnnee = $lastYear . '-' . str_pad($mois, 2, '0', STR_PAD_LEFT); // Format 'Y-m'
            $moisTexte = DateTime::createFromFormat('!m', $mois)->format('F'); // 'F' donne le nom complet du mois

            $ventesParMoisAnneePrecedenteFormatted[] = [
                'mois' => $moisTexte,
                'totalVente' => isset($ventesParMoisAnneePrecedente[$moisAnnee]) ? $ventesParMoisAnneePrecedente[$moisAnnee] : 0,
            ];
        }
       
        // $ventesParMoisFormatted = array_reverse($ventesParMoisFormatted);
        if (count($ventesParMoisFormatted) < 2) {
            $pourcentageArrondi = 0; // Ou une autre valeur par défaut
        } else {
            // Récupérez les deux dernières valeurs du tableau
            $derniereValeur = end($ventesParMoisFormatted);
            $avantDerniereValeur = prev($ventesParMoisFormatted);
            if($avantDerniereValeur['totalVente']==0){
                $pourcentageMensuel=100;
            }else{
                // Calculez le pourcentage de changement
                 $pourcentageMensuel = (($derniereValeur['totalVente'] - $avantDerniereValeur['totalVente']) / $avantDerniereValeur['totalVente']) * 100;
            }
            if ($pourcentageMensuel > 100) {
                $pourcentageMensuel = 100;
            }
            
            $partieEntiere = floor($pourcentageMensuel); // Partie entière
            $partieDecimale = $pourcentageMensuel - $partieEntiere; // Partie décimale
        
            // Si la partie décimale est supérieure ou égale à 0.7, arrondissez à l'entier supérieur
            if ($partieDecimale >= 0.7) {
                $pourcentageArrondi = ceil($pourcentageMensuel);
            } else {
                $pourcentageArrondi = $partieEntiere;
            }
        }
        return response()->json([
            'totalVentes' => $totalVentes,
            'ventesParMois' => $ventesParMoisFormatted,
            'ventesParMoisAnneePrecedente' => $ventesParMoisAnneePrecedenteFormatted,
            'pourcentageMensuel' => $pourcentageArrondi,
        ], 200);
    }
    public function calculTaux($store) {
        $boutique = Boutique::where('id', $store)->with('clients.commandes.produits')->with('clients.commandes.statutLivraison')->firstOrFail();
        $clients = $boutique->clients;
        // Prix total de vente de toutes les commandes de l'année en cours
        $totalVentes = 0;
        $totalRemboursement = 0;
        $currentYear = date('Y');
        // Créez une liste pour stocker les identifiants des clients ayant passé au moins une commande
        $clientsAvecCommandes = [];
        foreach ($clients as $client) {
            $customer_id= $client->id;
            $orders = $client->commandes;
            // dd($orders);
            foreach ($orders as $order) {
                $prix = $order->total;
                $date = new DateTime($order->created_at);
                $year = $date->format('Y');
        
                // Ajouter le prix de la commande au total des ventes de l'année en cours
                if ($year == $currentYear) {
                    if ($order->status == 'completed') {
                        $totalVentes += $prix;
                        // Ajouter l'identifiant du client à la liste s'il n'y est pas déjà
                        $customerId = $customer_id;
                        if (!in_array($customerId, $clientsAvecCommandes)) {
                            $clientsAvecCommandes[] = $customerId;
                        }
                    } elseif ($order->status == 'refunded') {
                        $totalRemboursement += $prix;
                    }
                }
            }
        }
        // Comptez le nombre de clients dans la liste
        $nombreTotalDeClientsAvecCommandes = count($clientsAvecCommandes);
    
        // $nombreTotalDeCommandes = count($orders);
        $nombreTotalDeClients = count($clients);
        if ($nombreTotalDeClients == 0) {
            $tauxConversion = 0;
        } else {
            $tauxConversion = ($nombreTotalDeClientsAvecCommandes / $nombreTotalDeClients) * 100;
        }
        if ($totalVentes == 0) {
            $tauxRemboursement = 0;
        } else {
            $tauxRemboursement = ($totalRemboursement / $totalVentes) * 100;
        }
        // Séparez la partie entière et décimale
        $partieEntiereConversion = floor($tauxConversion); // Partie entière
        $partieDecimaleConversion = $tauxConversion - $partieEntiereConversion; // Partie décimale

        // Si la partie décimale est supérieure ou égale à 0.7, arrondissez à l'entier supérieur
        if ($partieDecimaleConversion >= 0.7) {
            $tauxConversionArrondi = ceil($tauxConversion);
        } else {
            $tauxConversionArrondi = $partieEntiereConversion;
        }
        // Séparez la partie entière et décimale
        $partieEntiereRemboursement = floor($tauxRemboursement); // Partie entière
        $partieDecimaleRemboursement = $tauxRemboursement - $partieEntiereRemboursement; // Partie décimale
        // Si la partie décimale est supérieure ou égale à 0.7, arrondissez à l'entier supérieur
        if ($partieDecimaleRemboursement >= 0.7) {
             $tauxRemboursementArrondi = ceil($tauxRemboursement);
         } else {
                $tauxRemboursementArrondi = $partieEntiereRemboursement;
             }
        return response()->json([
            'tauxRemboursement' => $tauxRemboursementArrondi,
            'tauxConversion' => $tauxConversionArrondi,
            'nombreTotalDeClientsAvecCommandes' => $nombreTotalDeClientsAvecCommandes, // Nouveau résultat
        ], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
