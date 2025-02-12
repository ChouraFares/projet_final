<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'MLE',
        'user_id',
        'department',
        'selected_training',
        'status',
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
