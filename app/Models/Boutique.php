<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boutique extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'Nom',
        'Site',
        'Adresse',
        'Etat',
        'Email',
    ];
    public $timestamps = false;
}
