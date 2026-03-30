<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
   protected $fillable = [
    'amicale_id',
    'nom',
    'prenom',
    'telephone',
    'email',
    'promotion'
];

public function amicale()
{
    return $this->belongsTo(Amicale::class);
}

public function cotisations()
{
    return $this->hasMany(Cotisation::class);
}

public function loyers()
{
    return $this->hasMany(Loyer::class);
}

}


