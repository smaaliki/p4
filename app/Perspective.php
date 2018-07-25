<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perspective extends Model
{
    public function focus_areas()
    {
        # Perspective has many focus areas
        # Define a one-to-many relationship.
        return $this->hasMany('App\FocusArea');
    }
    public function pillar()
    {
        # Focus Area belongs to Perspective
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('App\Pillar');
    }

}
