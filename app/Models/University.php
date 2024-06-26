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
        'city',
        'address',
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
            'city' => $this->city,
            'address' => $this->address,
            'description' => $this->description,
            'link_to_website' => $this->link_to_website,
        ];
    }

    public function scopeSearch($query, $search='')
    {
        return $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('city', 'LIKE', '%' . $search . '%')
                    ->orWhere('address', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('link_to_website', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('specialties', function ($query) use($search){
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    });
    }

    public function dorms(): HasMany
    {
        return $this->hasMany(Dorm::class);
    }
    
    public function specialties()
    {
        return $this->belongsToMany(Speciality::class, 'speciality_university', 'university_id', 'specialty_id');
    }
}

