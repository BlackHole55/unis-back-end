<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'added_timestamp',
        'updated_timestamp',
        'last_changed_admin',
    ];

    const UPDATED_AT = null; 
    const CREATED_AT = null;

    public function specialtiesUniversities()
    {
        return $this->belongsToMany(SpecialityUniversity::class);
    }
}
