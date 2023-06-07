<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MultiImage;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function ProductDetails($id,$slug)
    {
        $product = Product::findOrFail($id);
        $color = $product->product_color;
        $product_color = explode(',',$color);

        $size = $product->product_size;
        $product_size = explode(',',$size);

        $multiImage = MultiImage::where('product_id',$id)->get();

        $cat_id = $product->category_id ;
        $relatedProduct = Product::where('category_id',$cat_id)->where('id','!=',$id)->orderBy('id','DESC')->limit(4)->get();


        return view('frontend.product.product_details',compact('product','product_color','product_size','multiImage','relatedProduct'));
    }
}