<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    //

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}