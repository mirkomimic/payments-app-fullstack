<?php

namespace App\Http\Controllers\StripeApi;

use App\Http\Requests\ProductRequest;
use App\Services\Images\StoreProductImages;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends StripeApiController
{

  public function index()
  {
    $products = $this->stripe->products->all();
    $prices = $this->stripe->prices->all();

    return Inertia::render('Stripe/Products/Index', [
      'products' => $products,
      'prices' => $prices,
    ]);
  }

  public function show(string $id)
  {
    $product = $this->stripe->products->retrieve($id);

    $prices = $this->stripe->prices->all(['product' => $product->id]);

    return Inertia::render('Stripe/Products/Show', [
      'product' => $product,
      'prices' => $prices
    ]);
  }

  public function store(ProductRequest $request)
  {
    $images = StoreProductImages::store($request);

    if ($request->recurring) {
      $this->stripe->products->create([
        'name' => $request->name,
        'default_price_data' => [
          'currency' => 'EUR',
          'unit_amount' => $request->price,
          'recurring' => [
            'interval' => $request->interval
          ]
        ],
        'images' => $images
      ]);
    } else {
      $this->stripe->products->create([
        'name' => $request->name,
        'default_price_data' => [
          'currency' => 'EUR',
          'unit_amount' => $request->price
        ],
        'images' => $images
      ]);
    }


    return redirect()->back()->with('msg', 'Product created');
  }

  public function update(string $id, ProductRequest $request)
  {
    $images = StoreProductImages::store($request);

    $this->stripe->products->update($id, [
      'name' => $request->name,
      'default_price' => $request->price,
      'images' => $images
    ]);

    return redirect()->back()->with('msg', 'Product updated');
  }

  public function destroy(string $id)
  {
    // https://github.com/stripe/stripe-python/issues/658
    $product = $this->stripe->products->delete($id);

    if ($product->deleted) {
      return redirect()->back()->with('msg', 'Product deleted');
    }
  }
}
