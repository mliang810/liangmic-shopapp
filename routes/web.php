<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\bookmarkController;
use App\Http\Controllers\productController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\shopController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


if (env('APP_ENV') !== 'local') {
    URL::forceScheme('https');
}

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

// Route::get('/', function () {
//     return view('home');
// })->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');


// REGISTER
Route::get('/register', [RegistrationController::class, 'index'])->name('registration.index');
Route::post('/register', [RegistrationController::class, 'register'])->name('registration.create');

// SIGN IN
Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
// LOG OUT
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware(['userPermissions'])->group(function(){
    // view: profile, edit account information, edit bookmarks pages //TODO
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
});

//SHOP
//CREATE SHOP
Route::middleware(['userPermissions'])->group(function(){
    Route::get('/shop/create', [shopController::class, 'create'])->name('shop.create');
});
Route::post('/shop/create', [shopController::class, 'store'])->name('shop.store');

Route::get('/shop/{id}/add', [shopController::class, 'addProducts'])->name('shop.addProducts');
Route::get('/shop/{id}', [shopController::class, 'saveProducts'])->name('shop.saveProducts');

//VIEW SHOP
Route::get('/shop', [shopController::class, 'viewAll'])->name('shop.index');
Route::get('/shop/{id}', [shopController::class, 'view'])->name('shop.view');
// Route::post('/shop/{$id}', [shopController::class, 'filter'])->name('shop.filter');

Route::get('/shop/{id}/delete', [shopController::class, 'delete'])->name('shop.delete'); // delete shop
Route::get('/shop/{id}/{category_id}', [shopController::class, 'viewCat'])->name('shop.category');

//EDIT SHOP
// Route::get('/shop/{id}/edit', [shopController::class, 'edit'])->name('shop.edit');
// Route::post('/shop/{id}', [shopController::class, 'edit'])->name('shop.editPost');
Route::post('/shop/{id}', [shopController::class, 'update'])->name('shop.update');
Route::post('/shop/{id}/editOn', [shopController::class, 'edit_on'])->name('shop.editOn');
Route::post('/shop/{id}/editOff', [shopController::class, 'edit_off'])->name('shop.editOff');

// DELETE SHOP -- full
Route::post('/shop/{id}/delete', [shopController::class, 'deleteFinal'])->name('shop.deleteFinal');

//CREATE PRODUCT //VIEW PRODUCT/UPDATE PRODUCT
Route::get('/product/create', [productController::class, 'create'])->name('product.create');
Route::post('/product/create', [productController::class, 'store'])->name('product.store');
Route::get('/product/{id}', [productController::class, 'view'])->name('product.view');

Route::get('/product/{id}/edit', [productController::class, 'edit'])->name('product.edit');
Route::post('/product/{id}', [productController::class, 'update'])->name('product.update');

Route::post('/product/{id}/addToCart', [productController::class, 'addToCart'])->name('product.addToCart'); //addToCart

//DELETE PRODUCT
Route::get('/product/{id}/delete',[productController::class, 'delete'])->name('product.delete');
Route::post('/product/{id}/delete',[productController::class, 'deleteFinal'])->name('product.deleteFinal');

//BOOKMARKS
Route::get('/bookmarks',[bookmarkController::class, 'view'])->name('bookmark.index');
Route::post('/bookmarks/addBookmark/{id}',[bookmarkController::class, 'addBookmark'])->name('bookmark.addToBookmarks'); //product id

Route::get('/bookmarks/{id}/delete',[bookmarkController::class, 'delete'])->name('bookmark.delete'); //TODO
Route::post('/bookmarks/{id}/delete',[bookmarkController::class, 'deleteFinal'])->name('bookmark.deleteFinal'); //TODO