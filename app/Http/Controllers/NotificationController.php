<?php
// app/Http/Controllers/NotificationController.php
namespace App\Http\Controllers;

// app/Http/Controllers/NotificationController.php
namespace App\Http\Controllers;

use App\Models\CustomNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // section pour responsable financier 
  


    public function destroy($notificationId)
    {
        $notification = CustomNotification::where('id', $notificationId)
            ->where('notifiable_id', Auth::id())
            ->first();
    
        if ($notification) {
            $notification->delete();
            return response()->json([
                'success' => true,
                'unread_count' => CustomNotification::where('notifiable_id', Auth::id())
                    ->whereNull('read_at') // Correction ici
                    ->count()
            ]);
        }
        return response()->json(['success' => false], 404);
    }


    public function markAsRead($notificationId)
{
    $notification = CustomNotification::where('id', $notificationId)
        ->where('notifiable_id', Auth::id())
        ->first();

    if ($notification) {
        $notification->update([
            'read_at' => now() // On utilise seulement read_at
        ]);

        return response()->json([
            'success' => true,
            'unread_count' => CustomNotification::where('notifiable_id', Auth::id())
                ->whereNull('read_at')
                ->count()
        ]);
    }

    return response()->json(['success' => false], 404);
}



            // Section  Notifications Concernant Super Admin Transit
            public function AdminTransitshowNotifications()
            {
                // Section  Notifications Concernant Responsable Finance
                // Récupérer les 15 premières notifications non lues, triées par date décroissante
                $unreadNotifications = CustomNotification::where('notifiable_id', Auth::id())
                    ->where('notifiable_type', 'App\Models\User')
                    ->whereNull('read_at')
                    ->orderBy('created_at', 'desc') // Tri par date de création décroissante
                    ->limit(15) // Limiter à 15 résultats
                    ->get();
        
                return view('responsable_finance.notifications', compact('unreadNotifications'));
            }

            // section pour Super Admin Transit


             // section pour responsable financier 
   // app/Http/Controllers/NotificationController.php
public function SuperAdminTransitShowNotifications()
{
    // Récupérer les 15 premières notifications non lues de type PrepaymentRequestNotification
    $unreadNotifications = CustomNotification::where('type', 'App\Notifications\PrepaymentRequestNotification')
        ->whereNull('read_at')
        ->orderBy('created_at', 'desc')
        ->limit(15)
        ->get();

    return view('super_admin_transit.notifications', compact('unreadNotifications'));
}
            
                // Section  Notifications Concernant Super Admin Transit
                public function SuperAdminTransitDestroy()
                {
                    // Section  Notifications Concernant Responsable Finance
                    // Récupérer les 15 premières notifications non lues, triées par date décroissante
                    $unreadNotifications = CustomNotification::where('notifiable_id', Auth::id())
                        ->where('notifiable_type', 'App\Models\User')
                        ->whereNull('read_at')
                        ->orderBy('created_at', 'desc') // Tri par date de création décroissante
                        ->limit(15) // Limiter à 15 résultats
                        ->get();
            
                    return view('super_admin_transit.notifications', compact('unreadNotifications'));
                }

<<<<<<< HEAD
}
=======
}
>>>>>>> 73aa7d46b21da869958b907c679599bfb3cef23a
