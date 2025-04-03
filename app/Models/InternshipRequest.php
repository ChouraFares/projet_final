<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'MLE',
        'user_id',
        'department',
        'internship_type',
        'duration',
        'further_skills',
        'start_date',
        'cv_path',
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
