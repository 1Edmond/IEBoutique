<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoutiqueHistorique extends Model
{
    use HasFactory;
    protected $fillable = [
        'Libelle',
        'Description',
        'BoutiqueId',
        'Etat',
        'DateOperation',
    ];
    public $timestamps = false;
}
