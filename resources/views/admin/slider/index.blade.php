@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4>Slider List
                        <a href="{{ url('admin/sliders/create') }}" class="btn btn-primary float-end">Add Slider</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sliders as $slider)
                                <tr>
                                    <td>{{ $slider->id }}</td>
                                    <td>{{ $slider->title }}</td>
                                    <td>{{ $slider->description }}</td>
                                    <td>
                                        <img style="width:70px;height:70px;" src="{{ asset("$slider->image") }}"
                                            alt="slider">
                                    </td>
                                    <td>{{ $slider->status == '0' ? 'Visible' : 'Hidden' }}</td>
                                    <td>
                                        <a href="{{ url('admin/sliders/' . $slider->id . '/edit') }}"
                                            class="btn btn-success btn-sm">Edit</a>

                                        <a href="{{ url('admin/sliders/' . $slider->id . '/delete') }}"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure want to delete this data.!!')">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
