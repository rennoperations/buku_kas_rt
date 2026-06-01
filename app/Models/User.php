<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'no_rumah',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isBendahara(): bool
    {
        return $this->role === 'bendahara';
    }

    public function isWarga(): bool
    {
        return $this->role === 'warga';
    }
}