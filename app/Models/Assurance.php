<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assurance extends Model
{
    protected $fillable = ['date', 'numero_borderaux', 'status', 'MLE'];

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'MLE', 'MLE'); // Association avec la colonne MLE
    }
}

