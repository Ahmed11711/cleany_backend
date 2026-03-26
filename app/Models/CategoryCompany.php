<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryCompany extends Model
{
    public $table = 'category_company';

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
