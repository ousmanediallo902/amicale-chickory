<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loyer extends Model
{
    protected $fillable = [
        'etudiant_id',
        'mois',
        'annee',
        'montant',
        'statut',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
