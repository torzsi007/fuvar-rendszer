<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fuvarozo extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function jarmu()
    {
        return $this->hasOne(Jarmu::class, 'fuvarozo_id');
    }

    /**
     * Kapcsolat a munkákhoz (egy fuvarozónak több munkája lehet)
     */
    public function munkak()
    {
        return $this->hasMany(Munka::class, 'fuvarozo_id');
    }

    /**
     * Helper függvény: admin-e?
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Helper függvény: fuvarozó-e?
     */
    public function isFuvarozo()
    {
        return $this->role === 'fuvarozo';
    }
}
