<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function contactCenters() {
        return $this->belongsToMany('App\ContactCenter')->withTimestamps();
    }

    public static function getForCheckboxes()
    {

        $services = self::orderBy('name')->get();

        $servicesForCheckboxes = [];

        foreach ($services as $service) {
            $servicesForCheckboxes[$service['id']] = $service->name;
        }

        return $servicesForCheckboxes;
    }
}
