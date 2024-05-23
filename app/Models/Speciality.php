<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Speciality extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'description',
        'added_timestamp',
        'updated_timestamp',
        'last_changed_admin',
    ];

    const UPDATED_AT = null; 
    const CREATED_AT = null; 

    protected $table = 'specialties';

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    public function universities(): BelongToMany
    {
        return $this->belongsToMany(University::class);
    }
}
