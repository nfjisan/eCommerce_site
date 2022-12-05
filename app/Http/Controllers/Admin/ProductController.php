<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFromRequest;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.index');
    }

    public function create()
    {
        $brands=Brand::all();
        $categories = Category::all();
        return view('admin.product.create',compact('categories','brands'));
    }


    public function store(ProductFromRequest $request)
    {
        $validatedData =$request->validated();

        $category = Category::findOrFail($validatedData['category_id']);

        $product= $category->products()->create([
            'category_id' =>$validatedData['category_id'],
            'name' =>$validatedData['name'],
            'slug' =>Str::slug($validatedData['slug']),
            'brand' =>$validatedData['brand'],
            'small_des' =>$validatedData['small_des'],
            'description' =>$validatedData['description'],
            'original_price' =>$validatedData['original_price'],
            'selling_price' =>$validatedData['selling_price'],
            'quantity' =>$validatedData['quantity'],
            'trending' =>$request->trending ==true ? '1':'0',
            'status' =>$request->status ==true ? '1':'0',
            'meta_title' =>$validatedData['meta_title'],
            'meta_keyword' =>$validatedData['meta_keyword'],
            'meta_des' =>$validatedData['meta_des'],
        ]);
        if($request->hasFile('image')){
            $uploadPath ='upload/products/';
            $i = 1;
            foreach($request->file('image') as $imageFile){
                $extention = $imageFile->getClientOriginalExtension();
                $filename = time().$i++.'.'.$extention;
                $imageFile->move($uploadPath,$filename);
                $finalImagePathName = $uploadPath.'-'.$filename;

                $product->productImages()->create([
                    'product_id' =>$product->id,
                    'image' => $finalImagePathName,
                ]);
            }
        }


        return redirect('/admin/product')->with('message','product added succesfully');

    }
}
