<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Termek extends Model
{
    protected $table = 'termeks';
    
    protected $fillable = [
        'tanterem',
        'befogadokepesseg',
        'projektor',
        'tv',
        'tv_meret',
        'berbeadas_osszege',
        'szamitogepek_szama'
    ];

    protected $casts = [
        'projektor' => 'boolean',
        'tv' => 'boolean',
    ];
}