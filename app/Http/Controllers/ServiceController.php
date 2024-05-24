<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
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
            'img'=>['required'],
            'text'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(), 400);
        }
        $service = new Service();
        $service->title = $request->title;
        $service->text = $request->text;
        $service->price = $request->price;
        $path=$request->file('img')->store('public/img');
        $service->img ='/storage/'.$path;
        $service->save();
        return response()->json('Услуга успешно добавлена', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $services = Service::all();
        return response()->json($services);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $valid=Validator::make($request->all(),[
            'title'=>['required'],
            'price'=>['required'],
            'img'=>['required'],
            'text'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(), 400);
        }
        $service = Service::query()->where('id', $request->id)->first();
        $service->title = $request->title;
        $service->text = $request->text;
        $service->price = $request->price;
        $path=$request->file('img')->store('public/img');
        $service->img ='/storage/'.$path;
        $service->update();
        return response()->json('Услуга изменена', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $service = Service::query()->where('id', $request->id)->delete();
        return redirect()->back()->with('delete', 'Услуга удалена');
    }
}
