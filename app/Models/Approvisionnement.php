<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approvisionnement extends Model
{
    use HasFactory;
    protected $fillable = [
        'DateAppro',
        'Etat',
        'Prix',
        'CommandeId',
        'BoutiqueId',
        'ModeleId',
    ];
    public $timestamps = false;
}
