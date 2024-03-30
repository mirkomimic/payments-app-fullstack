<?php

namespace App\Services\StripeApi;

class PricesService extends StripeApiService
{
  public function retrieve(string $price_id): object
  {
    return $this->stripe->prices->retrieve($price_id);
  }
}
