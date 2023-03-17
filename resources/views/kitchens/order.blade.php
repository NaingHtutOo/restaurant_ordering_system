@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 col-lg-12">
            <h1 class="d-inline">Orders</h1>
            <span class="float-end">
              <a class="btn btn-outline-danger" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </span>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Orders</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Dish</th>
                    <th>Category</th>
                    <th>Table</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach( $orders as $order )
                  <tr>
                    <td>{{ $order->dish->name }}</td>
                    <td>{{ $order->dish->category->name }}</td>
                    <td>{{ $order->table->name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $status[$order->status] }}</td>
                    <td>
                    @switch($order->status)
                        @case(config('res.order_status.new'))
                            <a class="btn btn-outline-success me-1" href="{{ url("/order/$order->id/approve") }}">Approve</a>
                            <a class="btn btn-outline-danger" href="{{ url("/order/$order->id/cancel") }}"
                                onclick="event.preventDefault();
                                document.getElementById('order-cancel-form').submit();">
                                CANCEL
                            </a>

                            <form id="order-cancel-form" action="{{ url("/order/$order->id/cancel") }}" 
                                method="POST" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                            @break
                        @case(config('res.order_status.processing'))
                        <a class="btn btn-outline-info" href="{{ url("/order/$order->id/ready") }}">Ready</a>
                    @endswitch
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection
