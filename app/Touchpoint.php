<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Touchpoint extends Model
{
    public function contactCenters()
    {
        return $this->belongsToMany('App\ContactCenter')->withTimestamps();
    }

    public static function getForCheckboxes()
    {
        $touchpoints = self::get();

        $touchpointsForCheckboxes = [];

        foreach ($touchpoints as $touchpoint) {
            $touchpointsForCheckboxes[$touchpoint['id']] = $touchpoint->name;
        }

        return $touchpointsForCheckboxes;
    }
}
