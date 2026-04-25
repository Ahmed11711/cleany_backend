<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    public function ServiceItems()
    {
        return $this->hasMany(ServiceItem::class);
    }

    public function driverServices()
    {
        return $this->hasMany(DriverService::class, 'service_item_id');
    }
}
