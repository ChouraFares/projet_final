<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssuranceMaladie extends Model
{
    use HasFactory;

    protected $table = 'assurance_maladie';

    protected $fillable = [
        'date_envoi',
        'numero_borderaux',
        'bulletin_numero',
        'nom_adherent',
        'date_de_soin',
        'status',
        'reclamation',
        'created_at' // Ajoutez cette ligne
    ];



}
