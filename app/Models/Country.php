<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model {

    use HasFactory;

    protected $guarded = [];

    public function airports()
    {
        return $this->belongsToMany(Airport::class, 'airport_countries');
    }
    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'country_hotels');
    }

}
