<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'category_company')
            ->withPivot('region_id');
    }
}
