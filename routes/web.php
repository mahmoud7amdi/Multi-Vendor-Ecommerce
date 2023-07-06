<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController ;
use App\Http\Controllers\VendorController ;
use App\Http\Controllers\UserController ;
use App\Http\Controllers\Backend\BrandController ;
use App\Http\Controllers\Backend\CategoryController ;
use App\Http\Controllers\Backend\SubCategoryController ;
use App\Http\Controllers\Backend\PeoductController ;
use  App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Backend\VendorPeoductController ;
use App\Http\Controllers\Backend\SliderController ;
use App\Http\Controllers\Backend\BannerController ;
use App\Http\Controllers\Backend\CouponController ;
use App\Http\Controllers\Backend\ShippingAreaController ;
use App\Http\Controllers\Frontend\IndexController ;
use App\Http\Controllers\Frontend\CartController ;
use App\Http\Controllers\User\WishlistController ;
use App\Http\Controllers\User\CompareController ;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Home
//Route::get('/', function () {
//    return view('frontend.index');
//});



Route::get('/',[IndexController::class,'Index']);





//User Dashboard
Route::middleware(['auth'])->group(function (){
    Route::get('dashboard',[UserController::class,'UserDashboard'])->name('dashboard');
    Route::put('user/profile/store',[UserController::class,'UserProfileStore'])->name('user.profile.store');
    Route::get('user/logout',[UserController::class,'UserLogout'])->name('user.logout');
    Route::post('user/update/password',[UserController::class,'UserUpdatePassword'])->name('user.update.password');

});


//Route::get('allData',[VendorController::class,'Data']);






//admin Dashboard
Route::middleware(['auth','role:admin'])->group(function (){
    Route::get('admin/dashboard',[AdminController::class,'AdminDashboard'])->name('admin.dashboard');
    Route::get('admin/logout',[AdminController::class,'AdminLogout'])->name('admin.logout');
    Route::get('admin/profile',[AdminController::class,'AdminProfile'])->name('admin.profile');
    Route::post('admin/profile/store',[AdminController::class,'AdminProfileStore'])->name('admin.profile.store');
    Route::get('admin/change/password',[AdminController::class,'AdminChangePassword'])->name('admin.change.password');
    Route::post('admin/update/password',[AdminController::class,'AdminUpdatePassword'])->name('update.password');




});



//vendor Dashboard
Route::middleware(['auth','role:vendor'])->group(function (){
    Route::get('vendor/dashboard',[VendorController::class,'VendorDashboard'])->name('vendor.dashboard');
    Route::get('vendor/logout',[VendorController::class,'VendorLogout'])->name('vendor.logout');
    Route::get('vendor/profile',[VendorController::class,'VendorProfile'])->name('vendor.profile');
    Route::post('vendor/profile/store',[VendorController::class,'VendorProfileStore'])->name('vendor.profile.store');
    Route::get('Vendor/change/password',[VendorController::class,'VendorChangePassword'])->name('vendor.change.password');
    Route::post('vendor/update/password',[VendorController::class,'VendorUpdatePassword'])->name('vendor.update.password');
    Route::get('vendor',[VendorController::class.'VendorController']);

    Route::controller(VendorPeoductController::class)->group(function (){
        Route::get('all/vendor/product','AllVendorProduct')->name('vendor.all.product');
        Route::get('add/vendor/product','AddVendorProduct')->name('vendor.add.product');
        Route::post('vendor/store/product','VendorStoreProducts')->name('vendor.store.product');
        Route::get('edit/vendor/product/{id}','EditVendorProduct')->name('edit.vendor.product');
        Route::put('update/vendor/product','UpdateVendorProduct')->name('update.vendor.product');
        Route::put('update/vendor/product/thumbnail','UpdateVendorProductThumbnail')->name('update.vendor.product.thumbnail');
        Route::put('update/vendor/product/multiImage','UpdateVendorProductMultiImage')->name('update.vendor.product.multiImage');
        Route::get('delete/vendor/product/multiImage/{id}','DeleteVendorProductMultiImage')->name('delete.vendor.multiImage.product');
        Route::get('vendor/product/inactive/{id}','VendorProductInactive')->name('vendor.product.inactive');
        Route::get('vendor/product/active/{id}','VendorProductActive')->name('vendor.product.active');
        Route::get('vendor/product/delete/{id}','ProductVendorDelete')->name('delete.vendor.product');
        Route::get('vendor/subcategory/ajax/{category_id}','VendorGetSubcategory');
        Route::get('all/vendor','AllVendor');




    });




});






// All Admin group routes
Route::middleware(['auth','role:admin'])->group(function (){

// All Brand routes
    Route::controller(BrandController::class)->group(function (){
        Route::get('all/brand','AllBrand')->name('all.brand');
        Route::get('add/brand','AddBrand')->name('add.brand');
        Route::post('store/brand','StoreBrand')->name('store.brand');
        Route::get('edit/brand/{id}','EditBrand')->name('edit.brand');
        Route::put('update/brand','UpdateBrand')->name('update.brand');
        Route::delete('delete/brand/{id}','DeleteBrand')->name('delete.brand');


    });




// All Category routes
    Route::controller(CategoryController::class)->group(function (){
        Route::get('all/category','AllCategory')->name('all.category');
        Route::get('add/category','AddCategory')->name('add.category');
        Route::post('store/category','StoreCategory')->name('store.category');
        Route::get('edit/category/{id}','EditCategory')->name('edit.category');
        Route::put('update/category','UpdateCategory')->name('update.category');
        Route::delete('delete/category/{id}','DeleteCategory')->name('delete.category');



    });




// All SubCategory routes
    Route::controller(SubCategoryController::class)->group(function (){
        Route::get('all/subcategory','AllSubCategory')->name('all.subCategory');
        Route::get('add/subcategory','AddSubCategory')->name('add.subCategory');
        Route::post('store/subcategory','StoreSubCategory')->name('store.subcategory');
        Route::get('edit/subcategory/{id}','EditSubCategory')->name('edit.subcategory');
        Route::put('update/subcategory','UpdateSubCategory')->name('update.subcategory');
        Route::delete('delete/subcategory/{id}','DeleteSubCategory')->name('delete.subcategory');
        Route::get('subcategory/ajax/{category_id}','GetSubcategory');



    });


// All Admin routes
    Route::controller(AdminController::class)->group(function (){
        Route::get('inactive/vendor','InactiveVendor')->name('inactive.vendor');
        Route::get('active/vendor','ActiveVendor')->name('active.vendor');
        Route::get('inactive/vendor/details/{id}','InactiveVendorDetails')->name('inactive.vendor.details');
        Route::put('active/vendor/approve','ActiveVendorApprove')->name('active.vendor.approve');
        Route::get('Active/vendor/details/{id}','ActiveVendorDetails')->name('active.vendor.details');
        Route::put('inactive/vendor/approve','InactiveVendorApprove')->name('inactive.vendor.approve');





    });



// All Product routes
    Route::controller(PeoductController::class)->group(function (){
        Route::get('all/product','AllProduct')->name('all.product');
        Route::get('add/product','AddProduct')->name('add.product');
        Route::post('store/product','StoreProducts')->name('store.product');
        Route::get('edit/product/{id}','EditProduct')->name('edit.product');
        Route::put('update/product','UpdateProduct')->name('update.product');
        Route::put('update/product/thumbnail','UpdateProductThumbnail')->name('update.product.thumbnail');
        Route::put('update/product/multiImage','UpdateProductMultiImage')->name('update.product.multiImage');
        Route::get('delete/product/multiImage/{id}','DeleteProductMultiImage')->name('delete.multiImage.product');
        Route::get('product/inactive/{id}','ProductInactive')->name('product.inactive');
        Route::get('product/active/{id}','ProductActive')->name('product.active');
        Route::get('product/delete/{id}','ProductDelete')->name('delete.product');




    });


// All Slider routes
    Route::controller(SliderController::class)->group(function (){
        Route::get('all/slider','AllSlider')->name('all.slider');
        Route::get('add/slider','AddSlider')->name('add.slider');
        Route::post('store/slider','StoreSlider')->name('store.slider');
        Route::get('edit/slider/{id}','EditSlider')->name('edit.slider');
        Route::put('update/slider','UpdateSlider')->name('update.slider');
        Route::get('delete/slider/{id}','DeleteSlider')->name('delete.slider');




    });



// All Banner routes
    Route::controller(BannerController::class)->group(function (){
        Route::get('all/banner','AllBanner')->name('all.banner');
        Route::get('add/banner','AddBanner')->name('add.banner');
        Route::post('store/banner','StoreBanner')->name('store.banner');
        Route::get('edit/banner/{id}','EditBanner')->name('edit.banner');
        Route::put('update/banner','UpdateBanner')->name('update.banner');
        Route::get('delete/banner/{id}','DeleteBanner')->name('delete.banner');




    });



// All Coupon routes
    Route::controller(CouponController::class)->group(function (){
        Route::get('all/coupon','AllCoupon')->name('all.coupon');
        Route::get('add/coupon','AddCoupon')->name('add.coupon');
        Route::post('store/coupon','StoreCoupon')->name('store.coupon');
        Route::get('edit/coupon/{id}','EditCoupon')->name('edit.coupon');
        Route::put('update/coupon','UpdateCoupon')->name('update.coupon');
        Route::delete('delete/coupon/{id}','DeleteCoupon')->name('delete.coupon');




    });





    //  Shipping Division routes
    Route::controller(ShippingAreaController::class)->group(function (){
        Route::get('all/division','AllDivision')->name('all.division');
        Route::get('add/division','AddDivision')->name('add.division');
        Route::post('store/division','StoreDivision')->name('store.division');
        Route::get('edit/division/{id}','EditDivision')->name('edit.division');
        Route::put('update/division','UpdateDivision')->name('update.division');
        Route::delete('delete/division/{id}','DeleteDivision')->name('delete.division');




    });



    //  Shipping District routes
    Route::controller(ShippingAreaController::class)->group(function (){
        Route::get('all/district','AllDistrict')->name('all.district');
        Route::get('add/district','AddDistrict')->name('add.district');
        Route::post('store/district','StoreDistrict')->name('store.district');
        Route::get('edit/district/{id}','EditeDistrict')->name('edit.district');
        Route::put('update/district','UpdateDistrict')->name('update.district');
        Route::delete('delete/district/{id}','DeleteDistrict')->name('delete.district');




    });




    //  Shipping State routes
    Route::controller(ShippingAreaController::class)->group(function (){
        Route::get('all/state','AllState')->name('all.state');
        Route::get('add/state','AddState')->name('add.state');
        Route::post('store/state','StoreState')->name('store.state');
        Route::get('edit/state/{id}','EditeState')->name('edit.state');
        Route::put('update/state','UpdateState')->name('update.state');
        Route::delete('delete/state/{id}','DeleteState')->name('delete.state');
        Route::get('district/ajax/{division_id}','GetDistrict');




    });



});

//product Details Frontend Route

Route::get('product/details/{id}/{slug}',[IndexController::class,'ProductDetails']);
Route::get('product/details/{id}',[IndexController::class,'VendorDetails'])->name('vendor.details');
Route::get('all/vendor',[IndexController::class,'AllVendor'])->name('vendor.all');
Route::get('product/category/{id}/{slug}',[IndexController::class,'CatWithProduct']);
Route::get('product/subcategory/{id}/{slug}',[IndexController::class,'SubCatWithProduct']);

//product quick view
Route::get('/product/view/modal/{id}',[IndexController::class,'ProductViewAjax']);
//Add To Cart
Route::post('cart/data/store/{id}',[CartController::class,'AddToCart']);

Route::get('/product/mini/cart',[CartController::class,'AddMiniCart']);

Route::get('/minicart/product/remove/{rowId}', [CartController::class, 'RemoveMiniCart']);

//Add To Cart Details
Route::post('/dcart/data/store/{id}',[CartController::class,'AddToCartDetails']);

Route::post('/add-to-wishlist/{product_id}',[WishlistController::class,'AddToWishlist']);

Route::post('/add-to-compare/{product_id}',[CompareController::class,'AddToCompare']);






Route::middleware(['auth','role:user'])->group(function (){
    Route::controller(WishlistController::class)->group(function (){
        Route::get('wishlist','AllWishlist')->name('wishlist');
        Route::get('/get-wishlist-product','GetWishlistProduct');
        Route::get('/wishlist-remove/{id}','WishlistRemove');
    });




    Route::controller(CompareController::class)->group(function (){
        Route::get('compare','AllCompare')->name('compare');
        Route::get('/get-compare-product','GetCompareProduct');
        Route::get('/compare-remove/{id}','CompareRemove');

    });

    Route::controller(CartController::class)->group(function (){
        Route::get('mycart','MyCart')->name('mycart');
        Route::get('/get-cart-product','GetCartProduct');
        Route::get('/cart-remove/{rowId}','CartRemove');
        Route::get('/cart-decrement/{rowId}','cartDecrement');
        Route::get('/cart-increment/{rowId}','cartIncrement');

    });



});
















Route::get('admin/login', [AdminController::class,'AdminLogin'])->middleware(RedirectIfAuthenticated::class);
Route::get('vendor/login', [VendorController::class,'VendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);
Route::get('become/vendor', [VendorController::class,'BecomeVendor'])->name('become.vendor');
Route::post('vendor/register', [VendorController::class,'VendorRegister'])->name('vendor.register');








Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
