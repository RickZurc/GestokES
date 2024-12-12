<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Events\OrderUpdated;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = new Order();
        if ($request->start_date) {
            $orders = $orders->where('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $orders = $orders->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        if ($request->min_price) {
            $orders = $orders->where('total', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $orders = $orders->where('total', '<=', $request->max_price);

            \dd($orders->get());

        }



        $orders = $orders->with(['items', 'payments', 'customer'])->latest()->paginate(10);

        $total = $orders->map(function ($i) {
            return $i->total();
        })->sum();
        $receivedAmount = $orders->map(function ($i) {
            return $i->receivedAmount();
        })->sum();

        event(new OrderUpdated('Order Placed'));

        return view('orders.index', compact('orders', 'total', 'receivedAmount'));
    }

    public function store(OrderStoreRequest $request)
    {
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'user_id' => $request->user()->id,
        ]);

        $cart = $request->user()->cart()->get();
        foreach ($cart as $item) {
            $order->items()->create([
                'price' => $item->price * $item->pivot->quantity,
                'quantity' => $item->pivot->quantity,
                'product_id' => $item->id,
            ]);
            $item->quantity = $item->quantity - $item->pivot->quantity;
            $item->save();
        }
        //$request->customer_id to int


        $request->user()->cart()->detach();
        $order->payments()->create([
            'amount' => $request->amount,
            'user_id' => $request->user()->id,
        ]);


        //run event OrderUpdated
        event(new OrderUpdated('Order Placed'));

        return 'success';
    }

    public function show(Order $order)
    {



        return view('orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {

        //add items back to stock
        foreach ($order->items as $item) {
            $product = $item->product;
            $product->quantity = $product->quantity + $item->quantity;
            $product->save();
        }
        //on the $order->payments() i only want to get the amount
        $amount = $order->payments()->first()->amount;
        $order->delete();

        //return success with amount and totalAmount
        return response()->json([
            'success' => true,
            'amount' => $amount,
            'totalAmount' => Payment::sum('amount')
        ]);


        return 'success';

        return response()->json([
            'success' => true
        ]);
    }
}
