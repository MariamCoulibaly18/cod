<?php

namespace App\Http\Controllers\Api;

use App\Models\Boutique;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;


class NotificationController extends Controller
{
    public function __construct()
    {
        //middleware
        //$this->authorize('is-super-admin');
        $this->middleware('auth:api');
    }
    public function getNotifications()
    {
        // Récupérez les notifications pour l'utilisateur actuellement connecté (super-admin, admin ou livreur)
        // $user = $request->user();
        $user = auth('api')->user();
        // dd($user);
        // if(Gate::allows('is-super-admin'))
        if($user->type=='super_admin'){
            $notifications = Notification::get();
             // Mettez à jour le nombre de notifications non lues du super-admin dans la session
            $notificationsRead = Notification::where('is_admin_read', false)->get();

        } else
        {
            $notifications = Notification::where('user_id', $user->id)->get(); 
            $notificationsRead = Notification::where('user_id', $user->id)->where('is_read', false)->get();
        }
        // Formater la date pour chaque notification non lue
        $formattedNotificationsRead = [];
        foreach ($notificationsRead as $notificationRead) {
            $formattedDateRead = $this->formatNotificationDate($notificationRead->created_at);
            $notificationRead->formatted_date = $formattedDateRead;
            $formattedNotificationsRead[] = $notificationRead;
        }
        // Formater la date pour chaque notification
        $formattedNotifications = [];
        foreach ($notifications as $notification) {
            $formattedDate = $this->formatNotificationDate($notification->created_at);
            $notification->formatted_date = $formattedDate;
            $formattedNotifications[] = $notification;
        }
        return response()->json(['notifications' => $formattedNotifications, 'notificationsRead'=>$formattedNotificationsRead]);
    }
    // Fonction pour formater la date selon les critères spécifiés
    private function formatNotificationDate($date)
    {
        $now = now();
        $notificationDate = \Carbon\Carbon::parse($date);

        if ($notificationDate->isToday()) {
            return 'Aujourd\'hui';
        } elseif ($notificationDate->isYesterday()) {
            return 'Hier';
        } elseif ($notificationDate->isCurrentWeek()) {
            return $notificationDate->format('l'); // Jour de la semaine
        } else {
            return $notificationDate->format('d-m-Y');
        }
    }

    public function markNotificationsAsRead()
    { 
        // Marquez toutes les notifications comme lues pour l'utilisateur actuellement connecté (super-admin, admin ou livreur)
        $user = auth('api')->user();
        // if (Gate::allows('is-super-admin')) 
        if($user->type=='super_admin'){
            Notification::where('is_admin_read', false)->update(['is_admin_read' => true]);
        } else {
            // Mettre à jour les notifications pour les autres utilisateurs
            Notification::where('user_id', $user->id)->update(['is_read' => true]);
        }
    
        return response()->json(['message' => 'Notifications marquées comme lues']);
    }

}
