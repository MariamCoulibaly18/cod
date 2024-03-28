<?php
// LivreurCommandeStatusUpdatedListener.php
namespace App\Listeners;
use Illuminate\Support\Facades\Broadcast;
use App\Events\LivreurCommandeStatusUpdated;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;

class LivreurCommandeStatusUpdatedListener
{
    public function handle(LivreurCommandeStatusUpdated $event)
    {
        // Récupérez l'admin de la boutique associée au livreur
        $adminId = $event->boutique->user_id;

        // Enregistrer la notification dans la session de l'admin
        session()->push("admin_notifications.{$adminId}", [
            'boutique_id' => $event->boutique->id,
            'livreur_id' => $event->livreurCommande->livreur_id,
            'commande_id' => $event->livreurCommande->order_id,
            'message' => $event->livreurCommande->accepted == 1 ? "Le livreur a accepté la commande #{$event->livreurCommande->order_id}." : "Le livreur a refusé la commande #{$event->livreurCommande->order_id}.",
            'status' => $event->livreurCommande->accepted == 1 ? 'accepted' : 'refused',
        ]);
        // // Diffusez la notification au frontend
        // $notificationData = [
        //     'boutique_id' => $event->boutique->id,
        //     'livreur_id' => $event->livreurCommande->livreur_id,
        //     'commande_id' => $event->livreurCommande->order_id,
        //     'message' => $event->livreurCommande->accepted == 1 ? "Le livreur a accepté la commande #{$event->livreurCommande->order_id}." : "Le livreur a refusé la commande #{$event->livreurCommande->order_id}.",
        //     'status' => $event->livreurCommande->accepted == 1 ? 'accepted' : 'refused',
        // ];

        // Broadcast::toOthers($notificationData);
    }
}
