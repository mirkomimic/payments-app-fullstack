<?php

namespace App\Http\Controllers\Stripe\Checkout;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Cashier\Cashier;

class ProductCheckoutController extends Controller
{

  public function store(CheckoutRequest $request)
  {
    // Due to Stripe limitations, you may not use the stored default payment method of a customer for single charges. 
    // https://docs.stripe.com/api/checkout/sessions/object
    $session = $request->user()->checkout(
      $request->items,
      [
        'success_url' => route('home') . '?session_id={CHECKOUT_SESSION_ID}',
      ]
    );

    session()->put('cart', []);

    return Inertia::location($session->url);
  }
}
