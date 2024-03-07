<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SimpleChargeController extends Controller
{
  public function index()
  {
    return Inertia::render('Stripe/SimpleCharge/Index');
  }

  public function store(Request $request)
  {
    // As of version 2023-08-16 of the API, we now require that a return_url is provided upon PaymentIntent confirmation.

    if (Auth::check()) {
      $request->user()->charge(
        $request->amount,
        $request->paymentMethodId,
        [
          'return_url' => route('home')
        ]
      );
    } else {
      (new User())->charge(
        $request->amount,
        $request->paymentMethodId,
        [
          'return_url' => route('home')
        ]
      );
    }

    return redirect()->route('home')->with('msg', 'Simple charge was successfull');
  }
}
