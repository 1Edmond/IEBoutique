<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;
    public $fillable = [
        'Libelle',
        'Description',
        'Prix',
        'DureeTarif',
        'DateAjout',
    ];
    public $timestamps = false;
}
