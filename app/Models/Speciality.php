<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'added_timestamp',
        'last_changed_admin',
        'updated_timestamp',
    ];

    const UPDATED_AT = null; 
    const CREATED_AT = null; 

    protected $table = 'specialties';
}
