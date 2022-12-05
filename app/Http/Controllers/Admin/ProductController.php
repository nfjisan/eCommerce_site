<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductFromRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products=Product::all();
        return view('admin.product.index',compact('products'));
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
                $finalImagePathName = $uploadPath.''.$filename;

                $product->productImages()->create([
                    'product_id' =>$product->id,
                    'image' => $finalImagePathName,
                ]);
            }
        }


        return redirect('/admin/product')->with('message','product added succesfully');

    }


    public function edit(int $product_id)
    {
        $brands=Brand::all();
        $categories = Category::all();
        $product = Product::findOrFail($product_id);
            return view('admin.product.editProduct',compact('categories','brands','product'));
    }

    public function update(ProductFromRequest $request, int $product_id)
    {
        $validatedData =$request->validated();

        $product = Category::findOrFail($validatedData['category_id'])->products()->where('id',$product_id)->first();
        if($product)
        {
            $product->update([
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
                    $finalImagePathName = $uploadPath.''.$filename;

                    $product->productImages()->create([
                        'product_id' =>$product->id,
                        'image' => $finalImagePathName,
                    ]);
                }
            }
            return redirect('/admin/product')->with('message','product Updated succesfully');
        }else{
            return redirect('admin/product')->with('message','No Such Product Id Found');
        }
    }


    public function destroyImage(int $product_image_id)
    {
        $productImage = ProductImage::findOrFail($product_image_id);
        if(File::exists($productImage->image)){
            File::delete($productImage->image);
        }
        $productImage->delete();
        return redirect()->back()->with('message','product Image Deleted');
    }

    public function destroy(int $product_id)
    {
        $product = Product::findOrFail($product_id);

        if($product->productImages){
            foreach($product->productImages as $image){
                if(File::exists($image->image)){
                    File::delete($image->image);
                }
            }
        }
        $product->delete();
        return redirect()->back()->with('message','product Deleted');
    }


}
