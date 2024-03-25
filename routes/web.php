<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Stripe\Checkout\ProductCheckoutController;
use App\Http\Controllers\Stripe\CustomersController;
use App\Http\Controllers\Stripe\PaymentMethodsController;
use App\Http\Controllers\Stripe\SimpleChargeController;
use App\Http\Controllers\StripeApi\PricesController;
use App\Http\Controllers\StripeApi\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
  return Inertia::render('Home');
})->name('home');

Route::get('/dashboard', function () {
  return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('simple-charge', SimpleChargeController::class)->only('index', 'store');
Route::resource('customers', CustomersController::class)->only('index', 'store', 'update', 'destroy');
Route::resource('payment-methods', PaymentMethodsController::class)->only('index', 'store', 'update', 'destroy');
Route::resource('checkout', ProductCheckoutController::class)->only('index', 'store', 'update', 'destroy');
Route::resource('products', ProductController::class)->only('index', 'show', 'store', 'update', 'destroy');
Route::resource('prices', PricesController::class)->only('store', 'update', 'destroy');

// Route::resource('cart', CartController::class)->only('store', 'update', 'destroy');
Route::post('cart', [CartController::class, 'store'])->name('cart.store');
Route::post('cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');

require __DIR__ . '/auth.php';
