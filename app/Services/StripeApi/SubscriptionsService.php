<?php

namespace App\Services\StripeApi;

class SubscriptionsService extends StripeApiService
{
  public function list(string $user_stripe_id = ''): object
  {
    return $this->stripe->subscriptions->all([
      'customer' => $user_stripe_id
    ]);
  }
}
