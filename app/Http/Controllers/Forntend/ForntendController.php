<?php

namespace App\Http\Controllers\Forntend;

use App\Models\Slider;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForntendController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status','0')->get();
        return view('forntend.index',compact('sliders'));
    }

    public function categories()
    {
        $categories = Category::where('status','0')->get();
        // return view('forntend.collection.category.index',compact('categories'));
        return view('layouts.inc.admin.forntend.collection.category.index',compact('categories'));
    }

    public function product($category_slug)
    {
        $category = Category::where('slug',$category_slug)->first();

        if($category){

            return view('layouts.inc.admin.forntend.collection.product.index',compact('category'));
        }else{
            return redirect()->back();
        }
    }

    public function productView(string $category_slug, string $product_slug)
    {
        $category = Category::where('slug',$category_slug)->first();

        if($category){

            $product = $category->products()->where('slug',$product_slug)->where('status','0')->first();

            if($product)
            {
                return view('layouts.inc.admin.forntend.collection.product.view',compact('category','product'));
            }else{
                return redirect()->back();
            }

        }else{
            return redirect()->back();
        }
    }
}
