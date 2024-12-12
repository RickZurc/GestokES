<?php
// app/Observers/OrderObserver.php
namespace App\Observers;

use App\Models\Order;
use App\Events\OrderUpdated;


class OrderObserver
{
    public function created(Order $order)
    {
        event(new OrderUpdated('Order Placed'));
    }

    public function updated(Order $order)
    {
        event(new OrderUpdated('Order Updated'));
    }
}
