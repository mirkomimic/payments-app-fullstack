<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Cashier\Cashier;

class CustomersController extends Controller
{
  public function index()
  {
    $users = User::query()->where('stripe_id', null)->get();
    $customers = User::query()->whereNot('stripe_id', null)->get();

    return Inertia::render('Stripe/Customers/Index', [
      'users' => $users,
      'customers' => $customers,
    ]);
  }

  public function store(Request $request)
  {
    $user = User::find($request->userId);

    $user->createAsStripeCustomer([
      'name' => $user->name,
      'email' => $user->email,
    ]);

    return redirect()->back()->with('msg', 'Stripe customer created');
  }

  public function update($id, Request $request)
  {
    $user = User::find($id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();

    $user->updateStripeCustomer([
      'name' => $request->name,
      'email' => $request->email
    ]);


    return redirect()->back()->with('msg', 'Customer updated');
  }

  public function destroy($userId)
  {
    $user = User::find($userId);

    $user->asStripeCustomer()->delete();
    $user->stripe_id = null;
    $user->save();

    return redirect()->back()->with('msg', 'Customer removed');
  }
}
