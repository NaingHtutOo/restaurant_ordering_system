@extends('layouts.front')

@section('content')

<div class="text-center bg-cyan text-dark shadow mb-3">
    <h5 class="fw-bolder py-5" 
    style="font-family: lucida-calligraphy, algerian, castellar; font-size: 65px;">Welcome To Terrace Restaurant</h5>
</div>

<div class="carousel slide mb-3" data-bs-ride="carousel" id="slide">
    <ol class="carousel-indicators">
        <li data-bs-target="#slide" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#slide" data-bs-slide-to="1"></li>
        <li data-bs-target="#slide" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="position-relative bg-dark" style="height: 200px">
                <div class="position-absolute text-white top-50 start-50 translate-middle">Event 01</div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="position-relative bg-primary" style="height: 200px">
                <div class="position-absolute text-white top-50 start-50 translate-middle">Event 02</div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="position-relative bg-secondary" style="height: 200px">
                <div class="position-absolute text-white top-50 start-50 translate-middle">Event 03</div>
            </div>
        </div>
    </div>
    <a href="#slide" class="carousel-control-prev" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a href="#slide" class="carousel-control-next" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>

<div class="card mb-3 shadow">
    <div class="card-header bg-info">
        <h3 class="card-title h4">Available Seats</h3>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($tables as $table)
            <div class="col-3 col-lg-2">
                <div class="card card-primary">
                    <div class="card-body text-center bg-info m-1">
                        <h5 class="h1">Table</h5>
                        <h5 class="h3">{{ $table->name }}</h5>
                    </div>
                    <div class="card-footer">
                        @if( $table->status == 1 )
                        <a href="{{ url("/table/$table->id") }}" class="btn btn-success text-center w-100">Take</a>
                        @else
                        <span class="btn btn-warning text-center w-100">Occupied</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <h3 class="card-title h4 text-dark">Available Foods & Drinks</h3>
        <span class="float-end me-3">
            <form method="post" action="/casher">
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
                    </div>
                                
                </div>

            </div>
        </div>

    </div>
@endforeach

@endsection