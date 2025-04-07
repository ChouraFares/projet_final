<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs'; // Spécifiez explicitement la table
    public $timestamps = false; // Les colonnes `created_at` et `updated_at` ne sont pas utilisées

    protected $guarded = []; // Autorise toutes les colonnes à être remplies
}