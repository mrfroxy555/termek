<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tulajdonos extends Model
{
    use HasFactory;

    protected $table = 'tulajdonos';

    protected $fillable = [
        'szemely_id',
        'auto_id'
    ];

    public function szemely()
    {
        return $this->belongsTo(Szemelyek::class, 'szemely_id');
    }

    public function auto()
    {
        return $this->belongsTo(autok::class, 'auto_id');
    }
}