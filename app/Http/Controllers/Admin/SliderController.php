<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderFormRequest;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.slider.index',compact('sliders'));
    }


    public function create()
    {
        return view('admin.slider.create');
    }


    public function store(SliderFormRequest $request)
    {
        $validatedData = $request->validated();

        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('upload/slider/',$filename);
            $validatedData['image'] ="upload/slider/$filename";
        }

        $validatedData['status'] = $request->status == true ? '1':'0';

        Slider::create([
            'title' =>$validatedData['title'],
            'description' =>$validatedData['description'],
            'image' =>$validatedData['image'],
            'status' =>$validatedData['status'],
        ]);

        return redirect('admin/sliders')->with('message','slider added successfully');
    }

    public function edit(slider $sliders)
    {
        return view('admin.slider.edit',compact('sliders'));
    }


    public function update(SliderFormRequest $request, slider $sliders)
    {
        $validatedData = $request->validated();

        if($request->hasFile('image')){

            $destination = $sliders->image;

            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('upload/slider/',$filename);
            $validatedData['image'] ="upload/slider/$filename";

        }

        $validatedData['status'] = $request->status == true ? '1':'0';

        Slider::where('id', $sliders->id)->update([
            'title' =>$validatedData['title'],
            'description' =>$validatedData['description'],
            'image' =>$validatedData['image'] ?? $sliders->image,
            'status' =>$validatedData['status'],
        ]);

        return redirect('admin/sliders')->with('message','slider updated successfully');
    }

    public function destroy(slider $sliders)
    {
        if($sliders->count() >0){
            $destination = $sliders->image;
            if(File::exists($destination)){
               File::delete($destination);
            }

            $sliders->delete();

            return redirect('admin/sliders')->with('message','slider deleted successfully');
        }

        return redirect('admin/sliders')->with('message','something with wrong');

    }

}
