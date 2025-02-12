<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LocalMission extends Model
{
    use HasFactory;

    protected $fillable = [
        'MLE',
        'user_id',  // Include user_id
        'mission_id',
        'superviseur',
        'region',
        'purpose',
        'start_date',
        'end_date',
        'accompanying_person',
        'license_plate',
        'car_type',
        'fuel_type',
        'carte_carburant',
        'distance_traveled',
        'fuel_cost',
        'toll_expenses',
        'hotel',
        'indemnity',
        'total_cost',
        'status',
        'report_details',
        'report_date',
        'receipt_path',
        'expenses_with_invoice',
    ];

    // Define the relationship to the User model
    public function employe()
    {
        return $this->belongsTo(Employe::class, 'MLE', 'MLE');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Utiliser 'user_id' comme clé étrangère
    }


}
