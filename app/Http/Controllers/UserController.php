<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function regUser(Request $request){
        $valid = Validator::make($request->all(),[
            'name'=>['required','regex:/[а-яА-ЯёЁ]/'],
            'surname'=>['required','regex:/[а-яА-ЯёЁ]/'],
            'email'=>['required', 'unique:users', 'email:dns,rfc'],
            'phone'=>['required', 'unique:users'],
            'password'=>['required','min:8', 'confirmed', 'regex:/[0-9A-Za-z]/']
        ],
        [
            'name.required'=>'Обязательное поле для заполнения',
            'name.regex'=>'Допустимые символы кириллица',
            'surname.required'=>'Обязательное поле для заполнения',
            'surname.regex'=>'Допустимые символы кириллица',
            'email.required'=>'Обязательное поле для заполнения',
            'email.unique'=>'Аккаунт с таким email уже создан',
            'email.email'=>'Неверный формат email',
            'phone.required'=>'Обязательное поле для заполнения',
            'phone.unique'=>'Аккаунт с таким email уже создан',
            'password.required'=>'Обязательное поле для заполнения',
            'password.confirmed'=>'Пароль неверно введен повторно',
            'password.regex'=>'Разрешенные символы латиница и цифры',
            'password.min'=>'Минимальное число символов 8',
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(), 400);
        }
        $user = new User();
        $user->name=$request->name;
        $user->surname=$request->surname;
        $user->email=$request->email;
        $user->phone=$request->phone;
        $user->password=md5($request->password);
        $user->save();
        Auth::login($user);
        return response()->json('Вы успешно зарегистрированы и авторизованы', 200);
    }
    public function authUser(Request $request){
        $valid = Validator::make($request->all(),[
            'phone'=>['required'],
            'password'=>['required']
        ],
        [
            'phone.required'=>'Поле обязательно для заполнения',
            'password.required'=>'Поле обязательно для заполнения'
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(), 400);
        }
        $user = User::query()
            ->where('phone', $request->phone)
            ->where('password', md5($request->password))->first();
        if($user){
            Auth::login($user);
            if($user->role=='1'){
                return redirect()->route('pageAdminOrders');
            }
            if($user->role=='0'){
                return redirect()->route('pageProfile');
            }
        }
        else {
            return response()->json('Неверный номер телефона или пароль', 404);
        }
    }
    public function exitUser(){
        Auth::logout();
        return redirect()->route('welcome');
    }
    public function show(User $user)
    {
        $user = User::query()->where('id', Auth::id())->first();
        return response()->json($user);
    }
    public function update(Request $request)
    {
        $valid=Validator::make($request->all(),[
            'name'=>['required'],
            'surname'=>['required'],
            'email'=>['required'],
            'phone'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(), 400);
        }
        $user = User::query()->where('id', Auth::id())->first();
        $user->name=$request->name;
        $user->surname=$request->surname;
        $user->email=$request->email;
        $user->phone=$request->phone;
        $user->update();
        return response()->json('Данные изменены', 200);
    }
}
