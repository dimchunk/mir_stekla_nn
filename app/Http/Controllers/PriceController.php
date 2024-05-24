<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PriceController extends Controller
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
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'title'=>['required'],
            'price'=>['required'],
            'service_id'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(), 400);
        }
        $price = new Price();
        $price->title = $request->title;
        $price->formula = $request->formula;
        $price->price = $request->price;
        $price->service_id = $request->service_id;
        $price->glass_id = $request->glass_id;
        $price->save();
        return response()->json('Цена успешно добавлена', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Price $price)
    {
        $prices = Price::query()->with(['service'])->get();;
        return response()->json($prices);
    }
    public function show1(Price $price)
    {
        $priceGlasses = Price::query()->where('service_id', 1)->with(['service'])->get();;
        return response()->json($priceGlasses);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Price $price)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Price $price)
    {
        $valid=Validator::make($request->all(),[
            'title'=>['required'],
            'price'=>['required'],
            'service_id'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(), 400);
        }
        $price = Price::query()->where('id', $request->id)->first();
        $price->title = $request->title;
        $price->formula = $request->formula;
        $price->price = $request->price;
        $price->service_id = $request->service_id;
        $price->glass_id = $request->glass_id;
        $price->update();
        return response()->json('Цена изменена', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $price = Price::query()->where('id', $request->id)->delete();
        return redirect()->back()->with('delete', 'Цена удалена');
    }
}
