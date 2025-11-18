<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $connection = 'pgsql2';   // <- tu BD HabilProf2
    protected $table = 'users';

    protected $fillable = ['name','rut','password'];

    protected $hidden = ['password','remember_token'];

    // Laravel hashea automáticamente al asignar password
    protected $casts = [
        'password' => 'hashed',
    ];
}
