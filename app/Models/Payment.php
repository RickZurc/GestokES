<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'amount',
        'order_id',
        'user_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    //sum of all payments but optimized
    public static function total()
    {
        \dd('ola');

        return self::sum('amount');
    }



}
