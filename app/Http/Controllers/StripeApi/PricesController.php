<?php

namespace App\Http\Controllers\StripeApi;

use App\Http\Requests\PriceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PricesController extends StripeApiController
{
  public function store(PriceRequest $request): RedirectResponse
  {

    $this->stripe->prices->create([
      'product' => $request->product_id,
      'unit_amount' => $request->price,
      'currency' => 'eur',
    ]);

    return redirect()->back()->with('msg', 'Price created');
  }

  public function update($price_id, Request $request): RedirectResponse
  {

    $this->stripe->products->update(
      $request->product_id,
      [
        'default_price' => $price_id,
      ]
    );

    return redirect()->back()->with('msg', 'Default price updated');
  }

  public function destroy($price_id): RedirectResponse
  {
    $this->stripe->prices->update(
      $price_id,
      [
        'active' => false
      ]
    );

    return redirect()->back()->with('msg', 'Price deactivated');
  }
}
