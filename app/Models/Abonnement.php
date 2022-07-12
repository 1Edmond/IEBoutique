<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;
    protected $fillable = [
        'DateAbonnement',
        'Tarif_Id',
        'Etat',
    ];
    public $timestamps = false;
}
