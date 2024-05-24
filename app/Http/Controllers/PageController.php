<?php

namespace App\Http\Controllers;

use App\Models\Glass;
use App\Models\Item;
use App\Models\Order;
use App\Models\Price;
use App\Models\Service;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function welcome(){
        $services_navbar = Service::all();
        $glasses = Glass::query()->take(4)->get();
        $services = Service::query()->take(3)->get();
        return view('welcome', ['glasses'=>$glasses, 'services'=>$services, 'services_navbar'=>$services_navbar]);
    }
    public function pageService(Service $service){
        $services = Service::query()->take(3)->get();
        $services_navbar = Service::all();
        $prices = Price::query()->where('service_id', $service->id)->get();
        $service = Service::query()->where('id', $service->id)->first();
        return view('service',['service'=>$service, 'prices'=>$prices, 'services_navbar'=>$services_navbar, 'services'=>$services]);
    }
    public function pageAuth(){
        $services = Service::query()->take(3)->get();
        $services_navbar = Service::all();
        return view('auth', ['services_navbar'=>$services_navbar, 'services'=>$services]);
    }
    public function pageCalculator(){
        $services = Service::query()->take(3)->get();
        $services_navbar = Service::all();
        return view('calculator', ['services_navbar'=>$services_navbar, 'services'=>$services]);
    }
    public function pageReg(){
        $services = Service::query()->take(3)->get();
        $services_navbar = Service::all();
        return view('reg', ['services_navbar'=>$services_navbar, 'services'=>$services]);
    }
    public function pageContacts(){
        $services = Service::query()->take(3)->get();
        $services_navbar = Service::all();
        return view('contacts', ['services_navbar'=>$services_navbar, 'services'=>$services]);
    }
    public function pageDelivery(){
        $services = Service::query()->take(3)->get();
        $services_navbar = Service::all();
        return view('delivery', ['services_navbar'=>$services_navbar, 'services'=>$services]);
    }
    public function pageProfile(){
        $services = Service::query()->take(3)->get();
        $services_navbar = Service::all();
        return view('profile', ['services_navbar'=>$services_navbar, 'services'=>$services]);
    }
    public function pageOrder(){
        $services = Service::query()->take(3)->get();
        $services_navbar = Service::all();
        return view('order', ['services_navbar'=>$services_navbar, 'services'=>$services]);
    }
    public function pageAdminServices(){
        $services = Service::query()->take(3)->get();
        $services_navbar = Service::all();
        return view('admin.services', ['services_navbar'=>$services_navbar, 'services'=>$services]);
    }
    public function pageAdminGlasses(){
        $services = Service::query()->take(3)->get();
        $services_navbar = Service::all();
        return view('admin.glasses', ['services_navbar'=>$services_navbar, 'services'=>$services]);
    }
    public function pageAdminPrices(){
        $services = Service::query()->take(3)->get();
        $services_navbar = Service::all();
        return view('admin.prices', ['services_navbar'=>$services_navbar, 'services'=>$services]);
    }
    public function pageAdminOrders(){
        $services = Service::query()->take(3)->get();
        $services_navbar = Service::all();
        return view('admin.orders', ['services_navbar'=>$services_navbar, 'services'=>$services]);
    }
    public function pageAdminInfo(Request $request){
        $services = Service::query()->take(3)->get();
        $services_navbar = Service::all();
        $items = Item::query()->where('order_id', $request->id)->get();
        $order = Order::query()->where('id', $request->id)->first();
        return view('admin.order_info', ['items'=>$items, 'services_navbar'=>$services_navbar, 'order'=>$order, 'services'=>$services]);
    }
    public function pageInfo(Request $request){
        $services = Service::query()->take(3)->get();
        $services_navbar = Service::all();
        $items = Item::query()->where('order_id', $request->id)->get();
        $order = Order::query()->where('id', $request->id)->first();
        return view('order_info', ['items'=>$items, 'services_navbar'=>$services_navbar, 'order'=>$order, 'services'=>$services]);
    }
    public function pageAdminApplications(Request $request){
        $services = Service::query()->take(3)->get();
        $services_navbar = Service::all();
        return view('admin.applications', ['services_navbar'=>$services_navbar, 'services'=>$services]);
    }
    public function pageGlasses(Request $request){
        $services = Service::query()->take(3)->get();
        $services_navbar = Service::all();
        return view('glasses', ['services_navbar'=>$services_navbar, 'services'=>$services]);
    }
}
