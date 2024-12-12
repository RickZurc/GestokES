<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Customer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'avatar',
        'instagram',
        'user_id',
    ];

    public function getAvatarUrl()
    {
        return Storage::url($this->avatar);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getTotalShotsOrdered()
    {
        return $this->orders()->with('items')->get()->sum(function ($order) {
            return $order->items->where('product_id', 5)->sum('quantity');
        });
    }
    public function getTotalCervejaOrdered()
    {
        return $this->orders()->with('items')->get()->sum(function ($order) {
            return $order->items->where('product_id', 1)->sum('quantity');
        });
    }

    public function getTotalSommeersby()
    {
        return $this->orders()->with('items')->get()->sum(function ($order) {
            return $order->items->where('product_id', 3)->sum('quantity');
        });
    }

    public function getTotalCanecaOrdered()
    {
        return $this->orders()->with('items')->get()->sum(function ($order) {
            return $order->items->where('product_id', 2)->sum('quantity');
        });
    }

    //get total sum of orders
    public function getTotalSpent()
    {
        return $this->orders()->with('items')->get()->sum(function ($order) {
            return $order->items->sum('price');
        });
    }

    //get total points, as 1 cerveja = 1 point 1 caneca = 2 points 1 shot = 2 points sommeersby = 1 point
    public function getTotalPoints()
    {
        return $this->getTotalShotsOrdered() * 2 + $this->getTotalCervejaOrdered() + $this->getTotalCanecaOrdered() * 2 + $this->getTotalSommeersby();
    }


}
