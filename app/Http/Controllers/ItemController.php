<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function ItemAdd(Request $request){

        $valid = Validator::make($request->all(),[
            'price_id'=>['required'],
            'width'=>['required'],
            'height'=>['required'],
            'count'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(), 400);
        }

        $order = Order::query()->where('user_id', Auth::id())
            ->where('status', 'Новый')
            ->firstOrCreate(['user_id'=>Auth::id()], ['status'=>'Новый']);

        $item = new Item();
        $item->order_id = $order->id;
        $item->price_id = $request->price_id;
        $item->width=$request->width;
        $item->height=$request->height;
        $item->count=$request->count;
        $item->save();
        return response()->json('Позиция успешно добавлена', 200);
    }
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        $order = Order::query()->where('user_id', Auth::id())->where('status', 'Новый')->first();

        $items = Item::query()->where('order_id', $order->id)->with(['price', 'order'])->get();
        return response()->json($items);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $valid=Validator::make($request->all(),[
            'price_id'=>['required'],
            'width'=>['required'],
            'height'=>['required'],
            'count'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(), 400);
        }
        $item = Item::query()->where('id', $request->id)->first();
        $item->price_id = $request->price_id;
        $item->width=$request->width;
        $item->height=$request->height;
        $item->count=$request->count;
        $item->update();
        return response()->json('Данные изменены', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $item = Item::query()->where('id', $request->id)->delete();
        return redirect()->back()->with('delete', 'Позиция удалена');
    }
}
