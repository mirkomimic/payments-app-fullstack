<?php

namespace App\Http\Controllers\Stripe\Checkout;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Cashier\Cashier;

class ProductCheckoutController extends Controller
{
  public function index()
  {
    return Inertia::render('Stripe/Checkout/Index');
  }

  public function store(Request $request)
  {
    // Due to Stripe limitations, you may not use the stored default payment method of a customer for single charges. 
    // https://docs.stripe.com/api/checkout/sessions/object
    $session = $request->user()->checkout(['price_1OqbFyKnRuwVl5Iv3oRTTX7R' => 2], [
      'success_url' => route('home') . '?session_id={CHECKOUT_SESSION_ID}',
    ]);

    return Inertia::location($session->url);
  }
}
