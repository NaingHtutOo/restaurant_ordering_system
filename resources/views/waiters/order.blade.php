@extends('layouts.front')

@section('content')

<div class="bg-cyan text-dark shadow mb-3">
    <h5 class="fw-bolder my-5 ms-3 d-inline"
        style="font-family: castellar; font-size: 65px;">Table {{ $table->name }}</h5>
    <a class="btn btn-outline-warning float-end my-3 me-2" data-bs-toggle="modal" data-bs-target="#leave">Leave</a>
</div>

<div class="card mb-3 shadow">
    <div class="card-header">
        <h3 class="card-title text-dark">Orders</h3>
    </div>
              <!-- /.card-header -->
    <div class="card-body">
        <table id="" class="table table-bordered table-striped text-dark">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $orders as $order )
                <tr>
                    <td>{{ $order->dish->name }}</td>
                    <td>{{ $order->dish->category->name }}</td>
                    <td>$ {{ $order->dish->price }}.00</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $status[$order->status] }}</td>
                    <td>
                        <a class="btn btn-outline-danger" href="{{ url("/order/$order->id/delete") }}"
                            onclick="event.preventDefault();
                            document.getElementById('order-delete-form').submit();">
                            DELETE
                        </a>

                        <form id="order-delete-form" action="{{ url("/order/$order->id/delete") }}" 
                            method="POST" class="d-none">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                    <td></td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>$ {{ $table->total }}.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <h3 class="card-title h4 text-dark">Available Foods & Drinks</h3>
        <span class="float-end me-3">
            <form method="post" action="{{ url("/table/$table->id") }}">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control" name="name" value=""/>
                    <button class="btn btn-secondary"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </span>
    </div>
    <div class="card-body">
        <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="all-tab" data-toggle="pill" href="#all" role="tab" 
                        aria-controls="all" aria-selected="true">All</a>
                    </li>
                    @foreach( $categories as $category )
                    <li class="nav-item">
                        <a class="nav-link" id="{{ $category->name }}-tab" data-toggle="pill" href="#{{ $category->name }}" role="tab" 
                        aria-controls="{{ $category->name }}" aria-selected="false">{{ $category->name }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                        <div class="container m-2 p-2">
                            <div class="row">
                                @foreach( $dishes as $dish )
                                    <div class="text-center col-12 col-lg-3">
                                        <div class="card mb-3" style="height: 300px" 
                                            data-bs-toggle="modal" data-bs-target="#dish<?= $dish->id ?>">
                                            <div class="card-body">
                                                <img src="{{url('/images/' . $dish->photo)}}" alt="{{ $dish->name }}" 
                                                    class="w-100 mb-2" style="height: 225px"/>
                                                <span class="h4 text-primary">{{ $dish->name }}</span>
                                            </div>
                                        </div>
                                    </div>    
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @foreach( $categories as $category )
                    <div class="tab-pane fade" id="{{ $category->name }}" role="tabpanel" aria-labelledby="{{ $category->name }}-tab">
                        <div class="container m-2 p-2">
                            <div class="row">
                                @foreach( $dishes as $dish )
                                    @if( $dish->category_id == $category->id)
                                    <div class="text-center col-12 col-lg-3">
                                        <div class="card mb-3" style="height: 300px" 
                                            data-bs-toggle="modal" data-bs-target="#dish<?= $dish->id ?>">
                                            <div class="card-body">
                                                <img src="{{url('/images/' . $dish->photo)}}" alt="{{ $dish->name }}" 
                                                    class="w-100 mb-2" style="height: 225px"/>
                                                <span class="h4 text-primary">{{ $dish->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif    
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@foreach( $dishes as $dish )
    <div class="modal" id="dish{{ $dish->id }}">
                
        <div class="modal-dialog">
            <div class="modal-content bg-secondary">
                        
                <div class="modal-header">
                    <h5 class="modal-title fw-bolder">{{ $dish->name }}</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                                
                    <div class="mb-2">
                        <img src="{{url('/images/' . $dish->photo)}}" alt="{{ $dish->name }}" 
                            class="w-100 mb-3"/>
                        
                        <div class="card bg-dark text-light mb-3">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Category</h5>
                                <span class="float-end">{{ $dish->category->name }}</span>
                            </div>
                        </div>

                        <div class="card bg-dark text-light mb-3">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Price</h5>
                                <span class="float-end">$ {{ $dish->price }}.00</span>
                            </div>
                        </div>

                        <form id="" action="{{ url("/table/$table->id/add/dish/$dish->id") }}" method="POST">
                            @csrf
                            <input type="number" class="form-control mb-3" id="quantity" name="quantity" value="{{ old('quantity', 0) }}">
                            <button class="btn btn-success float-end">Add to Orders</button>
                        </form>
                    </div>
                                
                </div>

            </div>
        </div>

    </div>
@endforeach

<div class="modal" id="leave">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success">Dear Customer!</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h5 class="text-success">Your bill will be $ {{ $table->total }}.00</h5>
                <form id="" action="{{ url("/table/$table->id/leave") }}" method="POST">
                @csrf
                    <button class="btn btn-danger float-end">Sure</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection