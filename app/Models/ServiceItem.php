<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceItem extends Model
{
    public function driverServices(): HasMany
    {
        return $this->hasMany(DriverService::class, 'service_item_id');
    }

    /**
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
