<?php

namespace App\Services\StripeApi;

use Stripe\StripeClient;

class StripeApiService
{
  protected $stripe;

  public function __construct()
  {
    $this->stripe = new StripeClient(env('STRIPE_SECRET'));
  }
}
