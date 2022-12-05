@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Products
                        <a href="{{ url('admin/product') }}" class="btn btn-warning float-end">Back</a>
                    </h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    @endif

                    <form action="{{ url('admin/product/' . $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home-tab-pane" type="button" role="tab"
                                    aria-controls="home-tab-pane" aria-selected="true">Home</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="seotag-tab" data-bs-toggle="tab"
                                    data-bs-target="#seotag-tab-pane" type="button" role="tab"
                                    aria-controls="seotag-tab-pane" aria-selected="false">SEO
                                    Tags</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="details-tab" data-bs-toggle="tab"
                                    data-bs-target="#details-tab-pane" type="button" role="tab"
                                    aria-controls="details-tab-pane" aria-selected="false">Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="image-tab" data-bs-toggle="tab"
                                    data-bs-target="#image-tab-pane" type="button" role="tab"
                                    aria-controls="image-tab-pane" aria-selected="false">Prducts
                                    Image</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade border p-3 show active" id="home-tab-pane" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="mb-3">
                                    <label>Select Category</label>
                                    <select name="category_id" class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Product Name</label>
                                    <input type="text" name="name" value="{{ $product->name }}" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Product Slug</label>
                                    <input type="text" name="slug" value="{{ $product->slug }}" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Select Brand</label>
                                    <select name="brand" class="form-control">
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->name }}"
                                                {{ $brand->name == $product->brand ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Small Description (500 Words)</label>
                                    <textarea name="small_des" class="form-control" rows="4">{{ $product->small_des }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                                </div>
                            </div>
                            <div class="tab-pane fade border p-3" id="seotag-tab-pane" role="tabpanel"
                                aria-labelledby="seotag-tab">
                                <div class="mb-3">
                                    <label>Meta Title</label>
                                    <textarea name="meta_title" class="form-control" rows="4">{{ $product->meta_title }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Meta Description</label>
                                    <textarea name="meta_des" class="form-control" rows="4">{{ $product->meta_des }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Meta Keyword</label>
                                    <textarea name="meta_keyword" class="form-control" rows="4">{{ $product->meta_keyword }}</textarea>
                                </div>
                            </div>
                            <div class="tab-pane fade border p-3" id="details-tab-pane" role="tabpanel"
                                aria-labelledby="details-tab">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Original Price</label>
                                            <input type="text" value="{{ $product->original_price }}"
                                                name="original_price" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Selling Price</label>
                                            <input type="text" value="{{ $product->selling_price }}"
                                                name="selling_price" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Quantity</label>
                                            <input type="text" value="{{ $product->quantity }}" name="quantity"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Trending</label>
                                            <input type="checkbox"
                                                value="{{ $product->trending == '1' ? 'checked' : '' }}" name="trending"
                                                style="width:50px; height:50px;">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Status</label>
                                            <input type="checkbox" name="status"
                                                value="{{ $product->status == '1' ? 'checked' : '' }}"
                                                style="width:50px;
                                                height:50px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade border p-3" id="image-tab-pane" role="tabpanel"
                                aria-labelledby="image-tab">
                                <div class="mb-3">
                                    <label>Upload Product Image</label>
                                    <input type="file" name="image[]" multiple class="form-control">
                                </div>
                                <div>
                                    @if ($product->productImages)
                                        <div class="row">
                                            @foreach ($product->productImages as $image)
                                                <div class="col-md-2">
                                                    <img src="{{ asset($image->image) }}"
                                                        style="width: 80px;height:80px;" class="me-4 border"
                                                        alt="img">
                                                    <a href="{{ url('admin/product-image/' . $image->id . '/delete') }}"
                                                        class="d-block">remove</a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <h5>No image Added</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
