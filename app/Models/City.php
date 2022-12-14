<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model {

    use HasFactory;

    protected $guarded = [];

    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'country_hotels');
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
