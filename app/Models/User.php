<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\LoanRequest;
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'MLE'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'MLE' => 'string',
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function employe() {
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
}
?>
