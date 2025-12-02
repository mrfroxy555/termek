<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class autok extends Model
{
    use HasFactory;

    protected $table = 'autoks';

    protected $fillable = [
        'rendszam',
        'tipus',
        'ar',
        'forgalom'
    ];

    // Many-to-Many kapcsolat: egy autónak több tulajdonosa lehet
    public function tulajdonosok()
    {
        return $this->belongsToMany(Szemelyek::class, 'tulajdonos', 'auto_id', 'szemely_id')
                    ->withTimestamps();
    }

    // Tulajdonos kapcsolatok
    public function tulajdonosList()
    {
        return $this->hasMany(Tulajdonos::class, 'auto_id');
    }
}