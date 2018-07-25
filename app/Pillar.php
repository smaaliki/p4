<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pillar extends Model
{
    public function perspectives()
    {
        # Focus Area has many Standards
        # Define a one-to-many relationship.
        return $this->hasMany('App\Perspective');
    }
}
