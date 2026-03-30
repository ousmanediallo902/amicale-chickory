<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subvention extends Model
{
    protected $fillable = [
        'source',
        'type',
        'montant',
        'date',
        'description',
    ];
}
