<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PaymentMethodsController extends Controller
{
  public function index()
  {
    $user = User::find(Auth::id());

    $paymentMethods = $user->paymentMethods();
    $setupIntent = $user->createSetupIntent();
    $defaultMethod = $user->defaultPaymentMethod();

    return Inertia::render('Stripe/PaymentMethods/Index', [
      'intent' => $setupIntent,
      'paymentMethods' => $paymentMethods,
      'defaultMethod' => $defaultMethod,
    ]);
  }

  public function store(Request $request)
  {

    $user = User::find(Auth::id());

    $user->addPaymentMethod($request->payment_method);
    $user->updateDefaultPaymentMethod($request->payment_method);

    return redirect()->back()->with('msg', 'Payment Method Added');
  }

  public function update(Request $request)
  {
    $user = User::find(Auth::id());

    $user->updateDefaultPaymentMethod($request->paymentMethodId);

    return redirect()->back()->with('msg', 'Payment Method Updated');
  }

  public function destroy(Request $request)
  {
    $user = User::find(Auth::id());

    $paymentMethod = $user->findPaymentMethod($request->paymentMethodId);
    $paymentMethod->delete();

    return redirect()->route('payment-methods.index')->with('msg', 'Payment Method Removed');
  }
}
