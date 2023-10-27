<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dorm;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'link_to_website',
        'added_timestamp',
        'last_changed_admin',
        'updated_timestamp',
    ];

    const UPDATED_AT = null; 
    const CREATED_AT = null; 

    /**
     * Get the dorms for the university.
     */
    public function dorms()
    {
        return $this->hasMany(Dorm::class, 'university_id');
    }
}
