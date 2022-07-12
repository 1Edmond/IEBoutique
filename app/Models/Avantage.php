<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avantage extends Model
{
    use HasFactory;
    protected $fillable = [
        'Description'
    ];
    public $timestamps = false;
}
