<?php

namespace App\Services\StripeApi;

class ProductsService extends StripeApiService
{
  public function retrieve(string $product_id): object
  {
    return $this->stripe->products->retrieve($product_id);
  }
}
