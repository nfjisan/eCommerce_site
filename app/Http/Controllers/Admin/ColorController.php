<?php

namespace App\Http\Controllers\Admin;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ColorFormRequest;

class ColorController extends Controller
{

    public function index()
    {
        $colors= Color::all();
        return view('admin.color.index',compact('colors'));
    }

    public function create()
    {
        return view('admin.color.create');
    }


    public function store(ColorFormRequest $request)
    {
        $validatedData = $request->validated();

        // Color::create($validatedData);
        $colors = new Color;
        $colors->name = $validatedData['name'];
        $colors->code = $validatedData['code'];
        $colors->status = $request->status == true ? '1':'0';
        $colors->save();

        return redirect('admin/colors')->with('message','Color Added Successfully');
    }


    public function edit(Color $colors)
    {
        return view('admin.color.edit',compact('colors'));
    }

    public function update(ColorFormRequest $request, $colors)
    {
        $validatedData = $request->validated();

        $colors = Color::findOrFail($colors);
        $colors->name = $validatedData['name'];
        $colors->code = $validatedData['code'];
        $colors->status = $request->status == true ? '1':'0';
        $colors->update();

        return redirect('admin/colors')->with('message','Color Updated Successfully');
    }


    public function destroy($colors_id)
    {
        $colors =Color::findOrFail($colors_id);
        $colors->delete();

        return redirect('admin/colors')->with('message','Color Deleted');
    }

}





