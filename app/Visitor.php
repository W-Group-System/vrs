<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    //
    protected $table = "visitors";

    public function location()
    {
        return $this->belongsTo(Building::class);
    }
    public function building()
    {
        return $this->belongsTo(Building::class, 'building_location', 'id');
    }
}
