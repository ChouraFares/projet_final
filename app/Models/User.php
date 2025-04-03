<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'MLE', 'settings', 'profile_photo'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'MLE' => 'string',
        'email_verified_at' => 'datetime',
        'settings' => 'array' // Ajout pour caster automatiquement settings en tableau
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function employe()
    {
        return $this->hasOne(Employe::class, 'MLE', 'MLE');
    }

    public function loanRequests()
    {
        return $this->hasMany(LoanRequest::class, 'MLE', 'MLE');
    }

    public function localMissions()
    {
        return $this->hasMany(LocalMission::class, 'user_id');
    }

    public function getSettingsAttribute($value)
    {
        return json_decode($value, true) ?? [
            'notifications' => true,
            'theme' => 'light',
            'language' => 'fr',
            'signature' => null
        ];
    }

    public function setSettingsAttribute($value)
    {
        $this->attributes['settings'] = json_encode($value);
    }
}