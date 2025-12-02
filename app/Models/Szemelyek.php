<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Szemelyek extends Model
{
    use HasFactory;

    protected $table = 'szemelyek';

    protected $fillable = [
        'nev',
        'tel',
        'email'
    ];

    // Many-to-Many kapcsolat: egy személynek több autója lehet
    public function autok()
    {
        return $this->belongsToMany(autok::class, 'tulajdonos', 'szemely_id', 'auto_id')
                    ->withTimestamps();
    }

    // Tulajdonos kapcsolatok
    public function tulajdonosok()
    {
        return $this->hasMany(Tulajdonos::class, 'szemely_id');
    }
}