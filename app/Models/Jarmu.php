<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jarmu extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'marka',
        'tipus',
        'rendszam',
        'fuvarozo_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function fuvarozo()
    {
        return $this->belongsTo(\App\Models\Fuvarozo::class, 'fuvarozo_id');
    }
}
