<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    public function AllBanner()
    {
        $banners = Banner::latest()->get();
        return view('backend.banner.all_banner',compact('banners'));
    }

    public function AddBanner()
    {
        return view('backend.banner.add_banner');
    }

    public function StoreBanner(Request $request)
    {
        $image = $request->file('banner_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(768,450)->save('upload/banner/'.$name_gen);
        $save_url = 'upload/banner/'.$name_gen;
        Banner::insert([
            'banner_title' => $request->banner_title ,
            'banner_url' => $request->banner_url ,
            'banner_image' => $save_url ,
        ]);
        $notification = array(
            'message' => 'Banner Added Successfully',
            'alert_type' => 'success'
        );
        return redirect()->route('all.banner')->with($notification);
    }

    public function EditBanner($id)
    {
        $banners = Banner::findOrFail($id);
        return view('backend.banner.edit_banner',compact('banners'));
    }

    public function UpdateBanner(Request $request)
    {
        $banner_id = $request->id;
        $old_img = $request->old_image ;
        if ($request->file('banner_image')){
            $image = $request->file('banner_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(768,450)->save('upload/banner/'.$name_gen);
            $save_url = 'upload/banner/'.$name_gen;
            if (file_exists($old_img)) {
                unlink($old_img);
            }
            Banner::findOrFail($banner_id)->update([
                'banner_title' => $request->banner_title ,
                'banner_url' => $request->banner_url ,
                'banner_image' => $save_url ,
            ]);
            $notification = array(
                'message' => 'Banner updated with image Successfully',
                'alert_type' => 'success'
            );
            return redirect()->route('all.banner')->with($notification);
        }else{
            Banner::findOrFail($banner_id)->update([
                'banner_title' => $request->banner_title ,
                'banner_url' => $request->banner_url
            ]);
            $notification = array(
                'message' => 'Banner updated without image Successfully',
                'alert_type' => 'success'
            );
            return redirect()->route('all.banner')->with($notification);

        }
    }


    public function DeleteBanner($id)
    {
        $banner = Banner::findOrFail($id);
        $image = $banner->banner_image ;
        unlink($image);
        Banner::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Banner deleted Successfully',
            'alert_type' => 'success'
        );
        return redirect()->route('all.banner')->with($notification);
    }
}
