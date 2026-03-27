<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class booking extends Model
{

    public function service()
    {
        return $this->belongsTo(Service::class,);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
