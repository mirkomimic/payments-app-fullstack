<?php

namespace App\Http\Controllers\StripeApi;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StripeApi\StripeApiController;
use App\Services\StripeApi\StripeCustomObjectsService;
use Illuminate\Http\RedirectResponse;

class SubscriptionController extends StripeApiController
{
  public function __construct(
    protected StripeCustomObjectsService $stripeCustomObjectsService,
  ) {
  }

  public function index()
  {
    $user = User::find(Auth::id());
    // dd($user->subscriptions);
    $subscriptions = $this->stripeCustomObjectsService->getCashierSubscriptions($user);

    return Inertia::render('Stripe/Subscriptions/Index', [
      'subscriptions' => $subscriptions
    ]);
  }

  public function store(Request $request)
  {
    $user = User::find(Auth::id());

    $user->newSubscription(
      'default',
      $request->price
    )->add();

    return redirect()->back()->with('msg', 'Subscription created');
  }

  public function destroy(string $subscription_id, Request $request): RedirectResponse
  {
    $user = User::find(Auth::id());

    $user->subscription($request->type)->cancel();

    return redirect()->back()->with('msg', 'Subscription canceled');
  }
}
