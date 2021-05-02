<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\shopController;
use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

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
Route::get('/shop/create', [shopController::class, 'create'])->name('shop.create');
Route::post('/shop/create', [shopController::class, 'store'])->name('shop.store');

Route::get('/shop/{$id}/add', [shopController::class, 'addProducts'])->name('shop.addProducts');
Route::get('/shop/{$id}', [shopController::class, 'saveProducts'])->name('shop.saveProducts');

//VIEW SHOP
Route::get('/shop/{id}', [shopController::class, 'view'])->name('shop.view');
// Route::post('/shop/{$id}', [shopController::class, 'filter'])->name('shop.filter');

Route::get('/shop/{$id}/{$category_id}', [shopController::class, 'viewCat'])->name('shop.category');

//EDIT SHOP
Route::get('/shop/{$id}/edit', [shopController::class, 'edit'])->name('shop.edit');
Route::post('/shop/{$id}', [shopController::class, 'update'])->name('shop.update');

//VIEW PRODUCT
