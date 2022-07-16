<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'Libelle',
        'Description',
        'DateAjout',
        'UserId',
    ];
    public $timestamps = false;
}
