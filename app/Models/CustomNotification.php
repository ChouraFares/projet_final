<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CustomNotification extends Model
{
    use HasFactory;
    
    protected $table = 'notifications';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'type',
        'data',
        'read_at',
        'notifiable_id',
        'notifiable_type'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = $model->id ?: Uuid::uuid4()->toString();
        });
    }

    public function getIsReadAttribute()
    {
        return !is_null($this->read_at);
    }

    public function notifiable()
    {
        return $this->morphTo();
    }

    // Accesseurs pour les données stockées dans le champ JSON
    public function getFactureNumberAttribute()
    {
        return $this->data['facture_number'] ?? null;
    }

    public function getFournisseurAttribute()
    {
        return $this->data['fournisseur'] ?? null;
    }

    public function getDateDemandeAttribute()
    {
        return $this->data['date_demande'] ?? null;
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 73aa7d46b21da869958b907c679599bfb3cef23a
