<?php

namespace App\Http\Controllers\StripeApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class StripeApiController extends Controller
{
  protected $stripe;

  public function __construct()
  {
    $this->stripe = new StripeClient(env('STRIPE_SECRET'));
  }
}
