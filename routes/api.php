<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\FournisseursController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    $user=$request->user();
    return $user;
});


//Api user
Route::apiResources(['user'=>'App\Http\Controllers\API\UserController']);
Route::put('profile',[App\Http\Controllers\API\UserController::class, 'updateProfile']);
Route::get('/getUserImage', [App\Http\Controllers\API\UserController::class, 'getUserImage']);

//boutique api
Route::apiResources(['boutique'=>'App\Http\Controllers\API\BoutiqueController']);
Route::get('boutique/{store}/connect',[App\Http\Controllers\API\BoutiqueController::class, 'connect']);
Route::put('{id}',[App\Http\Controllers\API\BoutiqueController::class, 'update']);

//boutique type api
Route::apiResources(['boutique_type'=>'App\Http\Controllers\API\BoutiqueTypesController']);
//profile api
/*Route::put('profile',[App\Http\Controllers\API\UserController::class, 'updateProfile']);*/

//Orders api
Route::prefix('order')->group(function(){
    Route::get('{store}', [App\Http\Controllers\API\OrderController::class, 'index'])->name('order.index');
    Route::get('export/{store}',[App\Http\Controllers\API\OrderController::class, 'export'])->name('order.export');
    Route::post('', [App\Http\Controllers\API\OrderController::class, 'store'])->name('order.store');
    Route::put('{id}', [App\Http\Controllers\API\OrderController::class, 'update'])->name('order.update');
    Route::get('{store}/{id}', [App\Http\Controllers\API\OrderController::class, 'show'])->name('order.show');
    Route::delete('{store}/{id}',[App\Http\Controllers\API\OrderController::class, 'destroy'])->name('order.destroy');

});
//Dashboard
Route::prefix('dashboard')->group(function(){
    Route::get('produitVendus/{store}', [App\Http\Controllers\API\DashboardController::class, 'produitVendus'])->name('dashboard.produitVendus');
    Route::get('commandes/{store}',[App\Http\Controllers\API\DashboardController::class, 'commandes'])->name('dashboard.commande');
    Route::get('ventes/{store}', [App\Http\Controllers\API\DashboardController::class, 'ventes'])->name('dashboard.vente');
    Route::get('calculTaux/{store}', [App\Http\Controllers\API\DashboardController::class, 'calculTaux'])->name('dashboard.calculTaux');
    Route::get('nombreBoutiques', [App\Http\Controllers\API\DashboardController::class, 'nombreBoutiques'])->name('dashboard.nombreBoutiques');

});
Route::put('updateStatutLivraison/{id}', [App\Http\Controllers\API\OrderController::class, 'updateStatutLivraison']);
// Route::put('orders/{id}', [App\Http\Controllers\API\OrderController::class, 'updateMultiple']);
Route::put('orders/modificationEnMasse', [App\Http\Controllers\API\OrderController::class, 'modificationEnMasse']);
Route::delete('orders/supprimerEnMasse',[App\Http\Controllers\API\OrderController::class, 'supprimerEnMasse']);

//product api  
Route::prefix('product')->group(function(){
    Route::get('{store}', [App\Http\Controllers\API\ProductController::class, 'index'])->name('product.index');
    // Route::get('{store}/page/{page}', [App\Http\Controllers\API\ProductController::class, 'index']);
    Route::post('', [App\Http\Controllers\API\ProductController::class, 'store'])->name('product.store');
    Route::post('import', [App\Http\Controllers\API\ProductController::class, 'import'])->name('product.import');
    Route::put('{product_id}', [App\Http\Controllers\API\ProductController::class, 'update'])->name('product.update');
    Route::delete('{store}/{product_id}',[App\Http\Controllers\API\ProductController::class, 'destroy'])->name('product.destroy');
});
Route::put('products/modificationEnMasse', [App\Http\Controllers\API\ProductController::class, 'modificationEnMasse']);
Route::delete('products/supprimerEnMasse',[App\Http\Controllers\API\ProductController::class, 'supprimerEnMasse']);

Route::post('productApi', [App\Http\Controllers\API\ProductController::class, 'productApi'])->name('product.productApi');

Route::get('getAttributes/{store}', [App\Http\Controllers\API\ProductController::class, 'getAttributes'])->name('product.getAttributes');
Route::put('updateQuantite/{product_id}', [App\Http\Controllers\API\ProductController::class, 'updateQuantite'])->name('productQuantite.update');

//category api
// Route::prefix('category')->group(function(){
//     Route::get('{store}', [App\Http\Controllers\API\CategoryController::class, 'index'])->name('category.index');
//     Route::post('', [App\Http\Controllers\API\CategoryController::class, 'store'])->name('category.store');
//     Route::put('{category_id}', [App\Http\Controllers\API\CategoryController::class, 'update'])->name('category.update');
//     Route::delete('{store}/{category_id}',[App\Http\Controllers\API\CategoryController::class, 'destroy'])->name('category.destroy');
// });
//categorie api
Route::prefix('categorie')->group(function(){
    Route::get('{store}', [App\Http\Controllers\API\CategoryController::class, 'index'])->name('categorie.index');
    Route::post('', [App\Http\Controllers\API\CategoryController::class, 'store'])->name('categorie.store');
    Route::put('{categorie_id}', [App\Http\Controllers\API\CategoryController::class, 'update'])->name('categorie.update');
    Route::delete('{store}/{categorie_id}',[App\Http\Controllers\API\CategoryController::class, 'destroy'])->name('categorie.destroy');
});
Route::delete('categories/supprimerEnMasse',[App\Http\Controllers\API\CategoryController::class, 'supprimerEnMasse']);

//customer api
Route::prefix('customer')->group(function(){
    Route::get('{store}', [App\Http\Controllers\API\CustomerController::class, 'index'])->name('customer.index');
    Route::post('', [App\Http\Controllers\API\CustomerController::class, 'store'])->name('customer.store');
    Route::post('import', [App\Http\Controllers\API\CustomerController::class, 'import'])->name('customer.import');
    Route::put('{customer_id}', [App\Http\Controllers\API\CustomerController::class, 'update'])->name('customer.update');
    Route::delete('{store}/{customer_id}',[App\Http\Controllers\API\CustomerController::class, 'destroy'])->name('customer.destroy');
});

//facture api
Route::prefix('facture')->group(function(){
    Route::put('{facture}', [App\Http\Controllers\API\FactureController::class, 'update'])->name('facture.update');
    Route::post('sendMail/{facture_id}',[App\Http\Controllers\API\FactureController::class, 'sendMail'])->name('facture.sendMail');
    //process facture
    Route::prefix('process')->group(function(){
        Route::get('{store}', [App\Http\Controllers\API\FactureController::class, 'getProcessFactures'])->name('facture.getProcessFactures');
        Route::get('download/{facture}',[App\Http\Controllers\API\FactureController::class, 'exportProcessFacture'])->name('facture.exportProcessFacture');
        Route::post('', [App\Http\Controllers\API\FactureController::class, 'createProcessFacture'])->name('facture.createProcessFacture');

    });
    //transaction facture
    Route::prefix('transaction')->group(function(){
        Route::get('{store}', [App\Http\Controllers\API\FactureController::class, 'getTransactionFactures'])->name('facture.getTransactionFactures');
        Route::get('download/{facture}',[App\Http\Controllers\API\FactureController::class, 'exportTransactionFacture'])->name('facture.exportTransactionFacture');
        Route::post('', [App\Http\Controllers\API\FactureController::class, 'createTransactionFacture'])->name('facture.createTransactionFacture');
    });
    //transaction facture
    Route::prefix('direct')->group(function(){
        Route::get('{store}', [App\Http\Controllers\API\FactureController::class, 'getDirectFactures'])->name('facture.getDirectFactures');
        Route::get('download/{facture}',[App\Http\Controllers\API\FactureController::class, 'exportDirectFacture'])->name('facture.exportDirectFacture');
        Route::post('', [App\Http\Controllers\API\FactureController::class, 'createDirectFacture'])->name('facture.createDirectFacture');
    });
    Route::prefix('download')->group(function(){
        Route::get('{store}/{commande}',[App\Http\Controllers\API\OrderController::class, 'exportBonDeCommande']);
    });
    /*Route::get('download/{store}/{facture}',[App\Http\Controllers\API\FactureController::class, 'download'])->name('facture.download');
    Route::post('sendMail/{facture_id}',[App\Http\Controllers\API\FactureController::class, 'sendMail'])->name('facture.sendMail');
    Route::post('', [App\Http\Controllers\API\FactureController::class, 'store'])->name('facture.store');*/
});

//payement api
Route::prefix('payement')->group(function(){
    Route::get('{fatcure}', [App\Http\Controllers\API\PayementController::class, 'index'])->name('payement.index');
    Route::post('', [App\Http\Controllers\API\PayementController::class, 'store'])->name('payement.store');
    Route::delete('{payement}',[App\Http\Controllers\API\PayementController::class, 'destroy'])->name('payement.destroy');
});
//brand api
Route::prefix('brand')->group(function(){
    Route::get('{store}', [App\Http\Controllers\API\BrandController::class, 'index'])->name('brand.index');
    Route::post('', [App\Http\Controllers\API\BrandController::class, 'store'])->name('brand.store');
    Route::put('{brand_id}', [App\Http\Controllers\API\BrandController::class, 'update'])->name('brand.update');
    Route::delete('{store}/{brand_id}',[App\Http\Controllers\API\BrandController::class, 'destroy'])->name('brand.destroy');
});
Route::delete('brands/supprimerEnMasse',[App\Http\Controllers\API\BrandController::class, 'supprimerEnMasse']);

//transaction api
Route::prefix('transaction')->group(function(){
    Route::get('{store}', [App\Http\Controllers\API\TransactionController::class, 'index'])->name('transaction.index');
    Route::post('', [App\Http\Controllers\API\TransactionController::class, 'store'])->name('transaction.store');
    Route::put('{transaction_id}', [App\Http\Controllers\API\TransactionController::class, 'update'])->name('transaction.update');
});
Route::post('transactionBrand', [App\Http\Controllers\Api\TransactionController::class, 'getBrand'])->name('transaction.getBrand');
Route::post('transactionQuantite', [App\Http\Controllers\Api\TransactionController::class, 'updateQuantite'])->name('transaction.updateQuantite');

//fournisseur api
// Route::apiResources(['fournisseur'=>'App\Http\Controllers\API\FournisseursController']);
Route::prefix('fournisseur')->group(function(){
    Route::get('{store}', [FournisseursController::class, 'index'])->name('fournisseur.index');
    Route::post('', [App\Http\Controllers\API\FournisseursController::class, 'store'])->name('fournisseur.store');
    Route::put('{fournisseur_id}', [App\Http\Controllers\API\FournisseursController::class, 'update'])->name('fournisseur.update');
    Route::delete('{fournisseur_id}',[App\Http\Controllers\API\FournisseursController::class, 'destroy'])->name('fournisseur.destroy');
});
Route::get('fournisseurs/{id}', [App\Http\Controllers\API\FournisseursController::class, 'getMarques']);
Route::post('fournisseurs/{id}/marques', [App\Http\Controllers\API\FournisseursController::class, 'addMarque']);
//fournisseurMarque api 
Route::apiResources(['fournisseurMarques'=>'App\Http\Controllers\API\FournisseurMarquesController']);
Route::post('fournisseurMarques/{fournisseur}', [App\Http\Controllers\API\FournisseurMarquesController::class, 'store']);
/*Route::post('productcreate', [App\Http\Controllers\API\ProductController::class, 'create']); */

//type api 
Route::apiResources(['type'=>'App\Http\Controllers\API\TypesFournisseursController']);

//marque api
Route::apiResources(['marque'=>'App\Http\Controllers\API\MarquesController']);
//Societe transport api
Route::prefix('societeTransport')->group(function(){
    Route::get('{store}', [App\Http\Controllers\API\SocieteTransportController::class, 'index'])->name('societeTransport.index');
    Route::get('boutique/{id}/connect',[App\Http\Controllers\API\SocieteTransportController::class, 'connect']);
    Route::post('', [App\Http\Controllers\API\SocieteTransportController::class, 'store'])->name('societeTransport.store');
    Route::put('{societeTransport_id}', [App\Http\Controllers\API\SocieteTransportController::class, 'update'])->name('societeTransport.update');
    Route::delete('{societeTransport_id}',[App\Http\Controllers\API\SocieteTransportController::class, 'destroy'])->name('societeTransport.destroy');
});
 //Livreur api
 Route::prefix('livreur')->group(function(){
    Route::get('{id}', [App\Http\Controllers\API\LivreurController::class, 'index'])->name('livreur.index');
    Route::post('', [App\Http\Controllers\API\LivreurController::class, 'store'])->name('livreur.store');
    Route::put('{livreur_id}', [App\Http\Controllers\API\LivreurController::class, 'update'])->name('livreur.update');
    Route::delete('{livreur_id}',[App\Http\Controllers\API\LivreurController::class, 'destroy'])->name('livreur.destroy');

});
//livreur_commmande api
Route::prefix('livreurCommande')->group(function(){
    Route::get('', [App\Http\Controllers\API\LivreurCommandesController::class, 'index'])->name('livreurCommande.index');
    Route::post('', [App\Http\Controllers\API\LivreurCommandesController::class, 'store'])->name('livreur_commande.store');
    Route::put('{livreurCommande_id}', [App\Http\Controllers\API\LivreurCommandesController::class, 'update'])->name('livreur_commande.update');
    Route::delete('{livreurCommande_id}',[App\Http\Controllers\API\LivreurCommandesController::class, 'destroy'])->name('livreur_commande.destroy');
});
 Route::prefix('assignedOrders')->group(function(){
    Route::get('', [App\Http\Controllers\API\ScreenLivreurController::class, 'index'])->name('assignedOrders.index');
    Route::put('{order_id}', [App\Http\Controllers\API\ScreenLivreurController::class, 'update'])->name('assignedOrders.update');
});
Route::post('updateStatus', [App\Http\Controllers\Api\ScreenLivreurController::class, 'updateStatus'])->name('assignedOrders.updateStatus');
Route::post('sendMailAdmin/{store}', [App\Http\Controllers\Api\ScreenLivreurController::class, 'sendMail'])->name('sendMailAdmin'); 
Route::post('sendNotification/{store}', [App\Http\Controllers\Api\ScreenLivreurController::class, 'sendNotification'])->name('sendNotification'); 
Route::post('expenseLivreur', [App\Http\Controllers\Api\ScreenLivreurController::class, 'expenseLivreur'])->name('expenseLivreur.expenseLivreur');
Route::put('updateLivraisonStatut/{id}', [App\Http\Controllers\Api\ScreenLivreurController::class, 'updateLivraisonStatut']);

//Point de vente api
Route::prefix('pointVente')->group(function(){
    Route::get('{store}', [App\Http\Controllers\API\PointVentesController::class, 'index'])->name('pointVente.index');
    Route::post('', [App\Http\Controllers\API\PointVentesController::class, 'store'])->name('pointVente.store');
    Route::put('{pointVente_id}', [App\Http\Controllers\API\PointVentesController::class, 'update'])->name('pointVente.update');
    Route::delete('{pointVente_id}',[App\Http\Controllers\API\PointVentesController::class, 'destroy'])->name('pointVente.destroy');
});
//Business Expense api
Route::prefix('businessExpense')->group(function(){
    Route::get('{store}', [App\Http\Controllers\API\BusinessExpensesController::class, 'index'])->name('businessExpense.index');
    Route::post('', [App\Http\Controllers\API\BusinessExpensesController::class, 'store'])->name('businessExpense.store');
    Route::put('{businessExpense_id}', [App\Http\Controllers\API\BusinessExpensesController::class, 'update'])->name('businessExpense.update');
    Route::delete('{businessExpense_id}',[App\Http\Controllers\API\BusinessExpensesController::class, 'destroy'])->name('businessExpense.destroy');
});
//Team expense api
Route::prefix('teamExpense')->group(function(){
    Route::get('{store}', [App\Http\Controllers\API\TeamExpensesController::class, 'index'])->name('teamExpense.index');
    Route::post('', [App\Http\Controllers\API\TeamExpensesController::class, 'store'])->name('teamExpense.store');
    Route::put('{teamExpense_id}', [App\Http\Controllers\API\TeamExpensesController::class, 'update'])->name('teamExpense.update');
    Route::delete('{teamExpense_id}',[App\Http\Controllers\API\TeamExpensesController::class, 'destroy'])->name('teamExpense.destroy');
});
//Category Depense api
Route::prefix('categoryExpenses')->group(function(){
    Route::get('', [App\Http\Controllers\API\CategoryDepensesController::class, 'index'])->name('categoryExpenses.index');
    Route::post('', [App\Http\Controllers\API\CategoryDepensesController::class, 'store'])->name('categoryExpenses.store');
    Route::put('{categoryExpenses_id}', [App\Http\Controllers\API\CategoryDepensesController::class, 'update'])->name('categoryExpenses.update');
    Route::delete('{categoryExpenses_id}',[App\Http\Controllers\API\CategoryDepensesController::class, 'destroy'])->name('categoryExpenses.destroy');
});
Route::post('providedCategory', [App\Http\Controllers\API\CategoryDepensesController::class, 'providedCategory'])->name('categoryExpenses.providedCategory');
Route::post('parentCategory', [App\Http\Controllers\API\CategoryDepensesController::class, 'parentCategory'])->name('categoryExpenses.parentCategory');
//Provided api
Route::prefix('provided')->group(function(){
    Route::get('', [App\Http\Controllers\API\ProvidedsController::class, 'index'])->name('provided.index');
    Route::post('', [App\Http\Controllers\API\ProvidedsController::class, 'store'])->name('provided.store');
    Route::put('{provided_id}', [App\Http\Controllers\API\ProvidedsController::class, 'update'])->name('provided.update');
    Route::delete('{provided_id}',[App\Http\Controllers\API\ProvidedsController::class, 'destroy'])->name('provided.destroy');
});

//Notification
// Route::get('/notifications', [App\Http\Controllers\API\UserController::class, 'showNotifications'])->name('boutique.notifications');
Route::get('getNotifications', [App\Http\Controllers\API\NotificationController::class, 'getNotifications']);
Route::post('markNotificationsAsRead', [App\Http\Controllers\API\NotificationController::class, 'markNotificationsAsRead']);
Route::post('updateUnreadNotificationsCount', [App\Http\Controllers\API\NotificationController::class, 'updateUnreadNotificationsCount']);

//Messagerie api
Route::prefix('messagerie')->group(function(){
    Route::get('{store}', [App\Http\Controllers\API\MessageriesController::class, 'index'])->name('messagerie.index');
    Route::post('', [App\Http\Controllers\API\MessageriesController::class, 'store'])->name('messagerie.store');
    Route::put('{messagerie_id}', [App\Http\Controllers\API\MessageriesController::class, 'update'])->name('messagerie.update');
    Route::delete('{messagerie_id}',[App\Http\Controllers\API\MessageriesController::class, 'destroy'])->name('messagerie.destroy');
});
//Template api
Route::prefix('template')->group(function(){
    Route::get('', [App\Http\Controllers\API\TemplatesController::class, 'index'])->name('template.index');
    Route::post('', [App\Http\Controllers\API\TemplatesController::class, 'store'])->name('template.store');
    Route::put('{template_id}', [App\Http\Controllers\API\TemplatesController::class, 'update'])->name('template.update');
    Route::delete('{template_id}',[App\Http\Controllers\API\TemplatesController::class, 'destroy'])->name('template.destroy');
});
//Api messagerie api
Route::prefix('apiMessagerie')->group(function(){
    Route::get('', [App\Http\Controllers\API\ApiMessageriesController::class, 'index'])->name('apiMessagerie.index');
    Route::post('', [App\Http\Controllers\API\ApiMessageriesController::class, 'store'])->name('apiMessagerie.store');
    Route::put('{apiMessagerie_id}', [App\Http\Controllers\API\ApiMessageriesController::class, 'update'])->name('apiMessagerie.update');
    Route::delete('{apiMessagerie_id}',[App\Http\Controllers\API\ApiMessageriesController::class, 'destroy'])->name('apiMessagerie.destroy');
});
//Statut livraison api
Route::prefix('statutLivraison')->group(function(){
    Route::get('', [App\Http\Controllers\API\StatutLivraisonsController::class, 'index'])->name('statutLivraison.index');
    Route::post('', [App\Http\Controllers\API\StatutLivraisonsController::class, 'store'])->name('statutLivraison.store');
    Route::put('{statutLivraison_id}', [App\Http\Controllers\API\StatutLivraisonsController::class, 'update'])->name('statutLivraison.update');
    Route::delete('{statutLivraison_id}',[App\Http\Controllers\API\StatutLivraisonsController::class, 'destroy'])->name('statutLivraison.destroy');
});