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
}
