<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController ;
use App\Http\Controllers\VendorController ;
use App\Http\Controllers\UserController ;
use App\Http\Controllers\Backend\BrandController ;
use App\Http\Controllers\Backend\CategoryController ;
use App\Http\Controllers\Backend\SubCategoryController ;

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
Route::get('/', function () {
    return view('frontend.index');
});









//User Dashboard
Route::middleware(['auth'])->group(function (){
    Route::get('dashboard',[UserController::class,'UserDashboard'])->name('dashboard');
    Route::post('user/profile/store',[UserController::class,'UserProfileStore'])->name('user.profile.store');
    Route::get('user/logout',[UserController::class,'UserLogout'])->name('user.logout');
    Route::post('user/update/password',[UserController::class,'UserUpdatePassword'])->name('user.update.password');

});






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






});







Route::middleware(['auth','role:admin'])->group(function (){

    Route::controller(BrandController::class)->group(function (){
        Route::get('all/brand','AllBrand')->name('all.brand');
        Route::get('add/brand','AddBrand')->name('add.brand');
        Route::post('store/brand','StoreBrand')->name('store.brand');
        Route::get('edit/brand/{id}','EditBrand')->name('edit.brand');
        Route::put('update/brand','UpdateBrand')->name('update.brand');
        Route::delete('delete/brand/{id}','DeleteBrand')->name('delete.brand');


    });

    Route::controller(CategoryController::class)->group(function (){
        Route::get('all/category','AllCategory')->name('all.category');
        Route::get('add/category','AddCategory')->name('add.category');
        Route::post('store/category','StoreCategory')->name('store.category');
        Route::get('edit/category/{id}','EditCategory')->name('edit.category');
        Route::put('update/category','UpdateCategory')->name('update.category');
        Route::delete('delete/category/{id}','DeleteCategory')->name('delete.category');



    });


    Route::controller(SubCategoryController::class)->group(function (){
        Route::get('all/subcategory','AllSubCategory')->name('all.subCategory');
        Route::get('add/subcategory','AddSubCategory')->name('add.subCategory');
        Route::post('store/subcategory','StoreSubCategory')->name('store.subcategory');
        Route::get('edit/subcategory/{id}','EditSubCategory')->name('edit.subcategory');
        Route::put('update/subcategory','UpdateSubCategory')->name('update.subcategory');
        Route::delete('delete/subcategory/{id}','DeleteSubCategory')->name('delete.subcategory');



    });



    Route::controller(AdminController::class)->group(function (){
        Route::get('inactive/vendor','InactiveVendor')->name('inactive.vendor');
        Route::get('active/vendor','ActiveVendor')->name('active.vendor');
        Route::get('inactive/vendor/details/{id}','InactiveVendorDetails')->name('inactive.vendor.details');
        Route::put('active/vendor/approve','ActiveVendorApprove')->name('active.vendor.approve');
        Route::get('Active/vendor/details/{id}','ActiveVendorDetails')->name('active.vendor.details');
        Route::put('inactive/vendor/approve','InactiveVendorApprove')->name('inactive.vendor.approve');





    });










});


Route::get('admin/login', [AdminController::class,'AdminLogin']);
Route::get('vendor/login', [VendorController::class,'VendorLogin'])->name('vendor.login');
Route::get('become/vendor', [VendorController::class,'BecomeVendor'])->name('become.vendor');
Route::post('vendor/register', [VendorController::class,'VendorRegister'])->name('vendor.register');







Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
