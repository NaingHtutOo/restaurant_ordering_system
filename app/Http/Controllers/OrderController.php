<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $status = array_flip( config( 'res.order_status' ) );
        $orders = Order::whereIn( 'status', [1,2] )->get();
        
        return view('kitchens.order' , [
            'orders' => $orders,
            'status' => $status,
        ]);
    }

    public function delete( Order $order )
    {
        $table = Table::find( $order->table_id );
        $table->total -= ( $order->quantity * $order->dish->price );
        $table->save();
        $order->status = config('res.order_status.canceled');
        $order->save();

        return redirect( route('kitchens.order') );
    }

    public function approve( Order $order )
    {
        $order->status = config('res.order_status.processing');
        $order->save();

        return redirect( route('kitchens.order') );
    }

    public function ready( Order $order )
    {
        $table = Table::find( $order->table_id );
        $table->total += ( $order->quantity * $order->dish->price );
        $table->save();
        $order->status = config('res.order_status.ready');
        $order->save();

        return redirect( route('kitchens.order') );
    }
}
