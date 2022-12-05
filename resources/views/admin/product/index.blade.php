@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3>Products
                        <a href="{{ url('admin/product/create') }}" class="btn btn-primary float-end">Add Product</a>
                    </h3>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
@endsection
