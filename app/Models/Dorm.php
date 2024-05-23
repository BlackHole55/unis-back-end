<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\University;
use Laravel\Scout\Searchable;

class Dorm extends Model
{
    use HasFactory;

    use Searchable {
        Searchable::search as parentSearch;
    }

    protected $fillable = [
        'university_id',
        'description',
        'city',
        'address',
        'price_tenge',
        'added_timestamp',
        'updated_timestamp',
        'last_changed_admin',
    ];

    const UPDATED_AT = null; 
    const CREATED_AT = null;

    public function toSearchableArray()
    {
        return [
            'university_id' => $this->university_id,
            'city' => $this->city,
            'address' => $this->address,
            'description' => $this->description,
            'price_tenge' => $this->price,
        ];
    }

    public function scopeSearch($query, $search='')
    {
        return $query->where('city', 'LIKE', '%' . $search . '%')
                    ->orWhere('address', 'LIKE', '%' . $search . '%')
                    ->orWhere('price_tenge', '<', $search )
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('university', function ($query) use($search){
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    });
    }

    /**
     * Perform a search against the model's indexed data.
     *
     * @param  string  $query
     * @param  \Closure  $callback
     * @return \Laravel\Scout\Builder   
     */
    // public static function search($query = '', $callback = null)
    // {
    //     return static::parentSearch($query, $callback)->query(function ($builder) {
    //         $builder->join('universities', 'universities.id', '=', 'dorms.university_id');
    //     });
    // }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class, 'university_id');
    }
}
