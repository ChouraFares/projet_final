<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $primaryKey = 'MLE';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'MLE',
        'Nom',
        'Prenom',
        'Zone_geographique',
        'Site',
        'Direction',
        'N+1',
        'Affectation',
    ];
    public function user()
    {
        return $this->hasMany(User::class, 'MLE', 'MLE');
    }
    public function loanRequests()
    {
        return $this->hasMany(LoanRequest::class, 'MLE', 'MLE');
    }
    // In Employe.php
public function localMissions()
{
    return $this->hasMany(LocalMission::class, 'MLE', 'MLE');
}




}
