<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->get();
        return view('forntend.order.index', compact('orders'));
    }

    public function show($orderId){
        $order = Order::where('user_id',Auth::user()->id)->where('id',$orderId)->first();
        if($order){
            return view('forntend.order.view', compact('order'));
        }else{
            return redirect()->back()->with('message','No Order Found');
        }

    }
}
