<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\DishRequest;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $dishes = Dish::all();
        
        return view('kitchens.dish' , [
            'dishes' => $dishes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('kitchens.create' , [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DishRequest $request)
    {
        $image = date('YmdHis') . "." . request()->photo->getClientOriginalExtension();
        request()->photo->move( public_path('images'), $image );

        $dish = new Dish();
        $dish->name = request()->name;
        $dish->category_id = request()->category_id;
        $dish->price = request()->price;
        $dish->photo = $image;
        $dish->save();

        return redirect(route('dishes.index'))->with( 'message', 'Dish Created Successfully' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)
    {
        $categories = Category::all();

        return view('kitchens.edit' , [
            'dish' => $dish,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dish $dish)
    {
        $validator = validator( request()->all(), [
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required',
        ]);

        if( $validator->fails() ) {
            return back()->withErors( $validator );
        }

        if( isset(request()->photo) ) {
            $image = date('YmdHis') . "." . request()->photo->getClientOriginalExtension();
            request()->photo->move( public_path('images'), $image );
        } else $image = $dish->photo;

        $dish->name = request()->name;
        $dish->category_id = request()->category_id;
        $dish->price = request()->price;
        $dish->photo = $image;
        $dish->save();

        return redirect(route('dishes.index'))->with( 'message', 'Dish Edited Successfully' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        $dish->delete();

        return redirect(route('dishes.index'))->with( 'message', 'Dish Delected Successfully' );
    }
}
