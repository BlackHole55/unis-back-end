<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'updated_timestamp',
        'last_changed_admin',
    ];

    const UPDATED_AT = null; 
    const CREATED_AT = null; 

    /**
     * Get the dorms for the university.
     */
    public function dorms(): HasMany
    {
        return $this->hasMany(Dorm::class);
    }
    
    public function specialties()
    {
        return $this->belongsToMany(Speciality::class, 'speciality_university', 'university_id', 'specialty_id')->as('faculty')->withPivot('price_per_year_tenge');
    }
}
