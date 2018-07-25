<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    public function focusArea()
    {
        # Standard belongs to Focus Area
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('App\FocusArea');
    }
}
