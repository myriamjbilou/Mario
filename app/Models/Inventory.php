<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';
    protected $primaryKey = 'inventory_id';

    public $timestamps = false;

    protected $fillable = [
        'film_id',
        'store_id',
        'existe',
        'last_update',
    ];

    public function film()
    {
        return $this->belongsTo(Film::class, 'film_id');
    }
}
