<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function AllSubCategory()
    {
        $subcategories = SubCategory::latest()->get();
        return view('backend.subcategory.all_subcategory',compact('subcategories'));
    }

    public function AddSubCategory()
    {
        $categories = Category::orderBy('category_name','ASC')->get();
        return view('backend.subcategory.add_subcategory',compact('categories'));
    }

    public function StoreSubCategory(Request $request)
    {
        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name' =>  $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
        ]);
        $notification = array(
            'message' => 'SubCategory Add Successfully',
            'alert_type' => 'success'
        );
        return redirect()->route('all.subCategory')->with($notification);
    }

    public function EditSubCategory($id)
    {
        $categories = Category::orderBy('category_name','ASC')->get();
        $subcategory = SubCategory::findOrFail($id);
        return view('backend.subcategory.edit_subcategory',compact('subcategory','categories'));
    }
    public function UpdateSubCategory(Request $request)
    {
        $subcat_id = $request->id;
        SubCategory::findOrfail($subcat_id)->update([
            'category_id' => $request->category_id,
            'subcategory_name' =>  $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
        ]);
        $notification = array(
            'message' => 'SubCategory Updated Successfully',
            'alert_type' => 'success'
        );
        return redirect()->route('all.subCategory')->with($notification);

    }

    public function DeleteSubCategory($id)
    {
        SubCategory::findOrFail($id)->delete();
        $notification = array(
            'message' => 'SubCategory Deleted Successfully',
            'alert_type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
}
