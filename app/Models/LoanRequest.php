<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'MLE',
        'Direction',
        'amount',
        'purpose',
        'type',
        'repayment_month',
        'additional_documents_path',
        'status'
    ];

    // Relation avec le modèle Employe
    public function employe()
    {
        return $this->belongsTo(Employe::class, 'MLE', 'MLE');
    }

    // Relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class, 'MLE', 'MLE');
    }
}
