<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Order;
use App\Models\Table;
use App\Models\Category;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $tables = Table::all();
        $dishes = Dish::all();
        $categories = Category::all();
        
        return view('waiters.casher' , [
            'tables' => $tables,
            'dishes' => $dishes,
            'categories' => $categories,
        ]);
    }

    public function search( Request $request )
    {
        $tables = Table::all();
        if( isset( request()->name ) ) {
            $dishes = Dish::where( 'name', request()->name )->get();
        } else {
            $dishes = Dish::all();
        }
        $categories = Category::all();
        
        return view('waiters.casher' , [
            'tables' => $tables,
            'dishes' => $dishes,
            'categories' => $categories,
        ]);
    }

    public function leave( Table $table )
    {
        Order::where( 'table_id', $table->id )->delete();
        $table->status = config('res.table_status.free');
        $table->total = 0;
        $table->save();
        
        return redirect("/casher");
    }

    public function seat( Table $table )
    {
        $table->status = config('res.table_status.occupied');
        $table->save();
        $dishes = Dish::all();
        $categories = Category::all();
        $orders = Order::where( 'table_id', $table->id )->get();
        $status = array_flip( config( 'res.order_status' ) );
        
        return view('waiters.order' , [
            'table' => $table,
            'dishes' => $dishes,
            'categories' => $categories,
            'orders' => $orders,
            'status' => $status,
        ]);
    }

    public function find( Table $table, Request $request )
    {
        if( isset( request()->name ) ) {
            $dishes = Dish::where( 'name', request()->name )->get();
        } else {
            $dishes = Dish::all();
        }
        $categories = Category::all();
        $orders = Order::where( 'table_id', $table->id )->get();
        $status = array_flip( config( 'res.order_status' ) );
        
        return view('waiters.order' , [
            'table' => $table,
            'dishes' => $dishes,
            'categories' => $categories,
            'orders' => $orders,
            'status' => $status,
        ]);
    }

    public function add( Table $table, Dish $dish, Request $request )
    {
        $data = Order::where( 'table_id', $table->id )->where( 'dish_id', $dish->id )->first();
        if( isset( $data ) && $data->status == config('res.order_status.new') ) {
            $order = $data;
            $order->quantity += request()->quantity;
            $order->status = config('res.order_status.new');
            $order->save();
        } else {
            $order = new Order;
            $order->table_id = $table->id;
            $order->dish_id = $dish->id;
            $order->quantity = request()->quantity;
            $order->status = config('res.order_status.new');
            $order->save();
        }
        
        return redirect("/table/$table->id");
    }

    public function delete( Order $order )
    {
        $table = Table::find( $order->table_id );
        $table->total -= ( $order->quantity * $order->dish->price );
        $table->save();
        $order->delete();

        return redirect("/table/$table->id");
    }

}
