<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuperAdmin extends Model
{
    protected $fillable = [
        'name', 'email', 'password', 'time_zone', 'access_token', 'refresh_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
