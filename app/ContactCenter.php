<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactCenter extends Model
{
    public function employees()
    {
        # CC has many Employees
        # Define a one-to-many relationship.
        return $this->hasMany('App\Employee');
    }

    public function services()
    {
        # withTimestamps will ensure the pivot table has its created_at/updated_at fields automatically maintained
        return $this->belongsToMany('App\Service')->withTimestamps();
    }
}
