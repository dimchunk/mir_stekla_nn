<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\GlassController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Главная
Route::get('/', [PageController::class, 'welcome'])->name('welcome');
//Авторизация
Route::get('/auth', [PageController::class, 'pageAuth'])->name('pageAuth');
Route::post('/auth/user', [UserController::class, 'authUser'])->name('authUser');
//Регистрация
Route::get('/reg', [PageController::class, 'pageReg'])->name('pageReg');
Route::post('/reg/user', [UserController::class, 'regUser'])->name('regUser');
//Выход
Route::get('/exit/user', [UserController::class, 'exitUser'])->name('exitUser');
//Профиль
Route::get('/profile', [PageController::class, 'pageProfile'])->name('pageProfile');
Route::get('/profile/get/user', [UserController::class, 'show'])->name('getUser');
Route::post('/profile/update/user', [UserController::class, 'update'])->name('updateUser');
//Заказ
Route::get('/order', [PageController::class, 'pageOrder'])->name('pageOrder');
Route::get('/delete/item/{id?}', [ItemController::class, 'destroy'])->name('deleteItem');
Route::post('/update/item', [ItemController::class, 'update'])->name('updateItem');
Route::post('/placed/order', [OrderController::class, 'placed'])->name('placedOrder');
//Контакты
Route::get('/contacts', [PageController::class, 'pageContacts'])->name('pageContacts');
//Доставка
Route::get('/delivery', [PageController::class, 'pageDelivery'])->name('pageDelivery');
//Калькулятор цен
Route::get('/calculator', [PageController::class, 'pageCalculator'])->name('pageCalculator');
//Услуга
Route::get('/service/{service}', [PageController::class, 'pageService'])->name('pageService');
//Стеклопакеты
Route::get('/glasses', [PageController::class, 'pageGlasses'])->name('pageGlasses');
//Заявки
Route::post('/add/application', [ApplicationController::class, 'store'])->name('addApplication');
Route::post('/add/application/navbar', [ApplicationController::class, 'addApplicationNavbar'])->name('addApplicationNavbar');
Route::post('/add/application/{service}', [ApplicationController::class, 'addApplicationService'])->name('addApplicationService');
//Оформление заказа
Route::post('/item/add', [ItemController::class, 'ItemAdd'])->name('ItemAdd');
Route::get('/get/order', [ItemController::class, 'show'])->name('getOrder');
Route::get('/get/orders/profile', [OrderController::class, 'show'])->name('getOrders');
Route::get('/info/order/{id?}', [PageController::class, 'pageInfo'])->name('pageInfo');

//Админ-панель
Route::group(['middlware'=>['admin','auth'],'prefix'=>'admin'], function(){
//CRUD услуг
Route::get('/admin/services', [PageController::class, 'pageAdminServices'])->name('pageAdminServices');
Route::post('/admin/add/service', [ServiceController::class, 'store'])->name('addService');
Route::get('/admin/get/services', [ServiceController::class, 'show'])->name('getServices');
Route::get('/admin/delete/service/{id?}', [ServiceController::class, 'destroy'])->name('deleteService');
Route::post('/admin/update/service', [ServiceController::class, 'update'])->name('updateService');
//CRUD стеклопакетов
Route::get('/admin/glasses', [PageController::class, 'pageAdminGlasses'])->name('pageAdminGlasses');
Route::post('/admin/add/glass', [GlassController::class, 'store'])->name('addGlass');
Route::get('/admin/get/glasses', [GlassController::class, 'show'])->name('getGlasses');
Route::get('/admin/delete/glass/{id?}', [GlassController::class, 'destroy'])->name('deleteGlass');
Route::post('/admin/update/glass', [GlassController::class, 'update'])->name('updateGlass');
//CRUD цен
Route::get('/admin/prices', [PageController::class, 'pageAdminPrices'])->name('pageAdminPrices');
Route::post('/admin/add/price', [PriceController::class, 'store'])->name('addPrice');
Route::get('/admin/get/prices', [PriceController::class, 'show'])->name('getPrices');
Route::get('/admin/get/price/glasses', [PriceController::class, 'show1'])->name('getPriceGlasses');
Route::get('/admin/delete/price/{id?}', [PriceController::class, 'destroy'])->name('deletePrice');
Route::post('/admin/update/price', [PriceController::class, 'update'])->name('updatePrice');
//CRUD заказов
Route::get('/admin/orders', [PageController::class, 'pageAdminOrders'])->name('pageAdminOrders');
Route::get('/admin/get/orders', [OrderController::class, 'show1'])->name('getOrdersAdmin');
Route::get('/admin/info/{id?}', [PageController::class, 'pageAdminInfo'])->name('pageAdminInfo');
Route::put('/admin/order/confirmed/{order}', [OrderController::class, 'confirmedOrder'])->name('confirmedOrder');
Route::put('/admin/order/finished/{order}', [OrderController::class, 'finishedOrder'])->name('finishedOrder');
Route::put('/admin/order/canceled/{order}', [OrderController::class, 'canceledOrder'])->name('canceledOrder');
});
//Заявки
Route::get('/admin/applications', [PageController::class, 'pageAdminApplications'])->name('pageAdminApplications');
Route::get('/admin/get/applications', [ApplicationController::class, 'show'])->name('getApplications');
