<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }


    // public function order()
    // {
    //     return $this->belongsTo(Order::class, 'order_id');
    // }

}
