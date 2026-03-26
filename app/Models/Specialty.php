<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    //

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

}