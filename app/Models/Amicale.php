<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amicale extends Model
{
    protected $fillable = [
        'nom',
        'adresse',
        'description',
    ];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }
}
