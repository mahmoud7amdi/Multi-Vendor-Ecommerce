<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function AllSlider()
    {
        $sliders = Slider::latest()->get();
        return view('backend.slider.all_slider',compact('sliders'));
    }

    public function AddSlider()
    {
        return view('backend.slider.add_slider');
    }

    public function StoreSlider(Request $request)
    {
        $image = $request->file('slider_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(2376,807)->save('upload/slider/'.$name_gen);
        $save_url = 'upload/slider/'.$name_gen ;
        Slider::insert([
            'slider_title' => $request->slider_title,
            'short_title' => $request->short_title,
            'slider_image' => $save_url,
        ]);
        $notification = array(
            'message' => 'Slider Added Successfully',
            'alert_type' => 'success'
        );
        return redirect()->route('all.slider')->with($notification);
    }
    public function EditSlider($id)
    {
        $sliders = Slider::findOrFail($id);
        return view('backend.slider.edit_slider',compact('sliders'));
    }

    public function UpdateSlider(Request $request)
    {
        $slider_id = $request->id ;
        $old_image = $request->old_image;
        if($request->file('slider_image')) {
            $image = $request->file('slider_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(2376, 807)->save('upload/slider/' . $name_gen);
            $save_url = 'upload/slider/' . $name_gen;

            if (file_exists($old_image)) {
                unlink($old_image);
            }
            Slider::findOrFail($slider_id)->update([
                'slider_title' => $request->slider_title,
                'short_title' => $request->short_title,
                'slider_image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Slider updated with image Successfully',
                'alert_type' => 'success'
            );
            return redirect()->route('all.slider')->with($notification);
        }else{
            Slider::findOrFail($slider_id)->update([
                'slider_title' => $request->slider_title,
                'short_title' => $request->short_title,

            ]);
            $notification = array(
                'message' => 'Slider updated without image Successfully',
                'alert_type' => 'success'
            );
            return redirect()->route('all.slider')->with($notification);
        }


    }

    public function DeleteSlider($id)
    {
        $sliders = Slider::findOrFail($id);
        $img = $sliders->slider_image ;
        unlink($img);
        Slider::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Slider Deleted Successfully',
            'alert_type' => 'success'
        );
        return redirect()->route('all.slider')->with($notification);
    }
}
