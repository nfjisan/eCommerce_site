@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4>Colors List
                        <a href="{{ url('admin/colors') }}" class="btn btn-warning float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/colors/' . $colors->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="">Color Name</label>
                            <input type="text" name="name" value="{{ $colors->name }}" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="">Color Code</label>
                            <input type="text" name="code" value="{{ $colors->code }}" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="">Status</label><br>
                            <input type="checkbox" {{ $colors->status ? 'checked' : '' }} style="width:30px;height:30px;"
                                name="status"> Checked=Hidden,
                            Unchecked=Visible
                        </div>
                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
