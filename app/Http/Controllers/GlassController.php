<?php

namespace App\Http\Controllers;

use App\Models\Glass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class GlassController extends Controller
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
            'img'=>['required'],
            'text'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(), 400);
        }
        $category = new Glass();
        $category->title = $request->title;
        $category->text = $request->text;
        $path=$request->file('img')->store('public/img');
        $category->img ='/storage/'.$path;
        $category->save();
        return response()->json('Категория стеклопакета успешно добавлена', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Glass $glass)
    {
        $categories = Glass::all();
        return response()->json($categories);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Glass $glass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Glass $glass)
    {
        $valid=Validator::make($request->all(),[
            'title'=>['required'],
            'img'=>['required'],
            'text'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(), 400);
        }
        $category = Glass::query()->where('id', $request->id)->first();
        $category->title = $request->title;
        $category->text = $request->text;
        $path=$request->file('img')->store('public/img');
        $category->img ='/storage/'.$path;
        $category->update();
        return response()->json('Стеклопакет изменен', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $category = Glass::query()->where('id', $request->id)->delete();
        return redirect()->back()->with('delete', 'Категория стеклопакета удалена');
    }
}
