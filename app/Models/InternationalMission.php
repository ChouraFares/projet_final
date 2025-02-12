<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternationalMission extends Model
{
    protected $fillable = [
        'MLE', // Ajouter 'MLE' dans les fillables pour permettre l'insertion
        'user_id',
        'mission_id',
        'superviseur',
        'purpose',
        'start_date',
        'end_date',
        'destination',
        'expenses',
        'interim',
        'divers',
        'mission_report',
        'receipt_path',
        'status',
        'report_details',
        'report_date',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'MLE', 'MLE');
    }
}
