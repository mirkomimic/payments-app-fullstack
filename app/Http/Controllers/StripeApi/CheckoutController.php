<?php

namespace App\Http\Controllers\StripeApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CheckoutController extends StripeApiController
{
  public function index(Request $request)
  {
    $checkout_session = $this->stripe->checkout->sessions->create([
      'ui_mode' => 'embedded',
      'line_items' => $request->items,
      'mode' => 'payment',
      'customer' => Auth::user()->stripe_id,
      'payment_method_types' => [
        'card'
      ],
      'return_url' => route('home') . '/?session_id={CHECKOUT_SESSION_ID}',
    ]);

    session()->put('cart', []);

    return Inertia::render('Stripe/Checkout/Index', [
      'clientSecret' => $checkout_session->client_secret
    ]);
  }
}
