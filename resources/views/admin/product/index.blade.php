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
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        @if ($product->category)
                                            {{ $product->category->name }}
                                        @else
                                            No category
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->selling_price }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->status == '1' ? 'Hidden' : 'Visible' }}</td>
                                    <td>
                                        <a href="{{ url('admin/product/' . $product->id . '/edit') }}"
                                            class="btn btn-success btn-sm">Edit</a>

                                        <a href="{{ url('admin/product/' . $product->id . '/delete') }}"
                                            onclick="return confirm('Are you sure want to delete this data.!!')"
                                            class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7">No Product Available</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
