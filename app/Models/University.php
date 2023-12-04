<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class University extends Model
{
    use HasFactory, Searchable;

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

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'location' => $this->location,
            'description' => $this->description,
            'link_to_website' => $this->link_to_website,
        ];
    }

    /**
     * Get the dorms for the university.
     */
    public function dorms(): HasMany
    {
        return $this->hasMany(Dorm::class);
    }
    
    public function specialties()
    {
        return $this->belongsToMany(Speciality::class, 'speciality_university', 'university_id', 'specialty_id')->withPivot('price_per_year_tenge');
    }
}
