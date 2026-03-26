<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{


    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function specialties()
    {
        return $this->hasMany(Specialty::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_company')
            ->withPivot('region_id');
    }


    public function specialty()
    {
        return $this->belongsToMany(Category::class, 'category_company')
            ->withPivot('region_id');
    }
    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }
}
