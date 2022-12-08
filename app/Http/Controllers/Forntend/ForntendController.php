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
}
