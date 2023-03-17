@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 col-lg-12">
            <h1 class="d-inline">Dishes</h1>
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
                <h3 class="card-title">Dishes</h3>
                <a href="{{ route('dishes.create') }}" class="float-end text-primary text-decoration-none">+ Add Dish</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach( $dishes as $dish )
                  <tr>
                    <td>{{ $dish->name }}</td>
                    <td>{{ $dish->category->name }}</td>
                    <td>$ {{ $dish->price }}.00</td>
                    <td>
                      <a class="btn btn-outline-success me-1" href="/dishes/{{ $dish->id }}/edit">EDIT</a>
                      <a class="btn btn-outline-danger" href="/dishes/{{ $dish->id }}"
                        data-bs-toggle="modal" data-bs-target="#confirm">
                        DELETE
                      </a>
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
    <div class="modal" id="confirm">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Are you sure?</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="dish-delete-form" action="/dishes/{{ $dish->id }}" method="POST">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger float-end">Yes</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content -->
  </div>
@endsection
