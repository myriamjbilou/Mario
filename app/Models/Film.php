<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $table = 'film';

    protected $primaryKey = 'film_id';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'release_year',
        'language_id',
        'original_language_id',
        'rental_duration',
        'rental_rate',
        'length',
        'replacement_cost',
        'rating',
        'special_features',
        'last_update',
    ];

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'film_id');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class, 'film_id');
    }
}
