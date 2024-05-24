<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Price;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
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
            'name'=>['required'],
            'phone'=>['required'],
        ],
        [
            'name.required'=>'Поле обязательно для заполнения',
            'phone.required'=>'Поле обязательно для заполнения',
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(), 400);
        }
        $application = new Application();
        $application->name = $request->name;
        $application->text = $request->text;
        $application->date =  date('Y-m-d H:i:s');
        $application->phone = $request->phone;
        $application->save();
        return response()->json('Заявка успешно отправлена', 200);
    }
    public function addApplicationService(Service $service, Request $request)
    {
        $request->validate([
            'name'=>['required'],
            'phone'=>['required'],
        ],
        [
            'name.required'=>'Поле обязательно для заполнения',
            'phone.required'=>'Поле обязательно для заполнения',
        ]);

        $application = new Application();
        $application->name = $request->name;
        $application->date =  date('Y-m-d H:i:s');
        $application->text = $request->text;
        $application->phone = $request->phone;
        $application->service_id = $service->id;
        $application->save();
        return redirect()->back()->with('ok', 'Заявка успешно отправлена');
    }
    public function addApplicationNavbar(Request $request)
    {
        $request->validate([
            'name'=>['required'],
            'phone'=>['required'],
        ],
        [
            'name.required'=>'Поле обязательно для заполнения',
            'phone.required'=>'Поле обязательно для заполнения',
        ]);

        $application = new Application();
        $application->name = $request->name;
        $application->date =  date('Y-m-d H:i:s');
        $application->text = $request->text;
        $application->phone = $request->phone;
        $application->save();
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        $applications = Application::all();
        return response()->json($applications);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
    }
}
