@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4>Edit List
                        <a href="{{ url('admin/sliders') }}" class="btn btn-primary float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/sliders/' . $sliders->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="">Title</label>
                            <input type="text" name="title" value="{{ $sliders->title }}" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="">Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ $sliders->description }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="">Image</label>
                            <input type="file" name="image" class="form-control">
                            <img src="{{ asset("$sliders->image") }}" style="width:40px;height:40px;">
                        </div>
                        <div class="mb-4">
                            <label for="">Status</label><br>
                            <input type="checkbox" name="status" value="{{ $sliders->status == '1' ? 'checked' : '' }}"
                                style="width:30px;height:30px;">
                            Checked=Hidden,
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
