<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasFactory,  HasApiTokens;

    protected $fillable = [
        'name',
        'password',
        'registered_timestamp',
        'last_login_timestamp',
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = false;
}
