<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImage;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class VendorPeoductController extends Controller
{
    public function AllVendorProduct()
    {
        $id = Auth::user()->id;
        $products = Product::where('vendor_id',$id)->latest()->get();
        return view('vendor.backend.product.all_vendor_product',compact('products'));
    }

    public function AddVendorProduct()
    {

        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        return view('vendor.backend.product.add_vendor_product',compact('brands','categories',));
    }

    public function VendorGetSubcategory($category_id)
    {
        $subcat = SubCategory::where('category_id', $category_id)->orderBy('subcategory_name','ASC')->get();

        return json_encode($subcat);

    }

    public function VendorStoreProducts(Request $request)
    {
        $image = $request->file('product_thumbnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(800,800)->save('upload/products/thumbnail/'.$name_gen);
        $save_url = 'upload/products/thumbnail/'.$name_gen;

        $product_id = Product::insertGetId([

            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),

            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,

            'product_thumbnail' => $save_url,
            'vendor_id' => Auth::user()->id,
            'status' => 1,
            'created_at' => Carbon::now(),

        ]);
        $images = $request->file('multi_img');
        foreach($images as $img){
            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(800,800)->save('upload/products/multi-image/'.$make_name);
            $uploadPath = 'upload/products/multi-image/'.$make_name;



            MultiImage::insert([

                'product_id' => $product_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(),

            ]);
        } // end foreach

        /// End Multiple Image Upload From her //////

        $notification = array(
            'message' => 'Vendor Product Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('vendor.all.product')->with($notification);
    }


    public function EditVendorProduct($id)
    {

        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategory = SubCategory::latest()->get();
        $multiImage = MultiImage::where('product_id',$id)->get();
        $product = Product::findOrfail($id);
        return view('vendor.backend.product.edit_vendor_product',compact('brands','categories','subcategory','product','multiImage'));
    }

    public function UpdateVendorProduct(Request $request)
    {
        $product_id = $request->id ;
        Product::findOrFail($product_id)->update([
            'brand_id' => $request->brand_id,

            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),

            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,



            'status' => 1,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Vendor Product Updated without image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('vendor.all.product')->with($notification);

    }

    public function UpdateVendorProductThumbnail(Request $request)
    {
        $pro_id = $request->id;
        $oldImage = $request->old_img;

        $image = $request->file('product_thumbnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(800,800)->save('upload/products/thumbnail/'.$name_gen);
        $save_url = 'upload/products/thumbnail/'.$name_gen;

        if (file_exists($oldImage)) {
            unlink($oldImage);
        }

        Product::findOrFail($pro_id)->update([

            'product_thumbnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => ' Vendor Product Image Thumbnail Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function UpdateVendorProductMultiImage(Request $request)
    {

        $imgs = $request->multi_img;

        foreach ($imgs as $id => $img) {
            $imgDel = MultiImage::findOrFail($id);
            unlink($imgDel->photo_name);

            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(800, 800)->save('upload/products/multi-image/' . $make_name);
            $uploadPath = 'upload/products/multi-image/' . $make_name;

            MultiImage::where('id', $id)->update([
                'photo_name' => $uploadPath,
                'updated_at' => Carbon::now(),

            ]);
        } // end foreach

        $notification = array(
            'message' => 'Product Multi Image Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }
    public function DeleteVendorProductMultiImage($id)
    {
        $oldImage = MultiImage::findOrfail($id);
        unlink($oldImage->photo_name);
        MultiImage::findOrfail($id)->delete();
        $notification = array(
            'message' => 'Vendor Product MultiImage Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function VendorProductInactive($id)
    {
        Product::findOrfail($id)->update([
            'status' => 0
        ]);
        $notification = array(
            'message' => 'Vendor Product Inactive Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function VendorProductActive($id)
    {
        Product::findOrfail($id)->update([
            'status' => 1
        ]);
        $notification = array(
            'message' => 'Vendor Product Active Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function ProductVendorDelete($id)
    {
        $product = Product::findOrfail($id);
        unlink($product->product_thumbnail);
        Product::findOrFail($id)->delete();
        $images = MultiImage::where('product_id',$id)->get();
        foreach ($images as $img){
            unlink($img->photo_name);
            MultiImage::where('product_id',$id)->delete();
        }
        $notification = array(
            'message' => ' Vendor Product Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
