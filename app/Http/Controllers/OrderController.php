<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function confirmedOrder(Request $request, Order $order)
    {
        $request->validate([
            'price'=>['required'],
        ]);
        $order = Order::query()->where('id', $order->id)->first();
        $order->price = $request->price;
        $order->status = 'Подтвержден';
        $order->update();
        return redirect()->route('pageAdminOrders');
    }
    public function finishedOrder(Request $request, Order $order)
    {
        $order = Order::query()->where('id', $order->id)->first();
        $order->status = 'Завершен';
        $order->date_end =  date('Y-m-d H:i:s');
        $order->update();
        return redirect()->route('pageAdminOrders');
    }
    public function canceledOrder(Request $request, Order $order)
    {
        $request->validate([
            'cause'=>['required'],
        ]);
        $order = Order::query()->where('id', $order->id)->first();
        $order->status = 'Отменен';
        $order->cause = $request->cause;
        $order->date_end =  date('Y-m-d H:i:s');
        $order->update();
        return redirect()->route('pageAdminOrders');
    }
    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $orders = Order::query()->where('user_id', Auth::id())->get();
        return response()->json($orders);
    }
    public function show1(Order $order)
    {
        $orders = Order::query()->with(['user'])->get();
        return response()->json($orders);
    }
    public function placed(){
        $order = Order::query()->where('user_id', Auth::id())->where('status', 'Новый')->first();
        $order->date_start = date('Y-m-d H:i:s');
        $order->status='Оформлен';
        $order->update();
        return redirect()->route('pageProfile');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
