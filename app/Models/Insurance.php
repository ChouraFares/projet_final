<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'numero_de_bordereau',
        'MLE',
        'status',
        'type'
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'MLE', 'MLE');
    }
}
