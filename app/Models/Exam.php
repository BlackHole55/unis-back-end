<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Exam extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'description',
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
            'description' => $this->description,
        ];
    }

    public function specialtiesUniversities()
    {
        return $this->belongsToMany(SpecialityUniversity::class);
    }
}
