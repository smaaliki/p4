<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FocusArea extends Model
{
    public function standards()
    {
        # Focus Area has many Standards
        # Define a one-to-many relationship.
        return $this->hasMany('App\Standard');
    }
    public function perspective()
    {
        # Focus Area belongs to Perspective
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('App\Perspective');
    }
}
