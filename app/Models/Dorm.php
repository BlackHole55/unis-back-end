<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\University;

class Dorm extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_id',
        'description',
        'location',
        'price_tenge',
        'added_timestamp',
        'last_changed_admin',
        'updated_timestamp',
    ];

    const UPDATED_AT = null; 
    const CREATED_AT = null; 

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id');
    }
}
