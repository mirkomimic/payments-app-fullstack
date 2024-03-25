<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
  public function store(Request $request): void
  {
    $cart = session()->get('cart', []);

    if (!empty($cart)) {
      if ($this->checkIfInCart($cart, $request->product)) {
        foreach ($cart as $key => $item) {
          if ($item['product']['id'] == $request->product['id']) {
            $cart[$key]['quantity']++;
          }
        }
      } else {
        $cart[] = [
          'product' => $request->product,
          'quantity' => $request->quantity,
          'price' => $request->price,
        ];
      }
    } else {
      $cart[] = [
        'product' => $request->product,
        'quantity' => $request->quantity,
        'price' => $request->price,
      ];
    }

    session()->put('cart', $cart);
  }

  public function remove(Request $request): void
  {
    $cart = session()->get('cart', []);

    if (!empty($cart)) {
      if ($this->checkIfInCart($cart, $request->product)) {
        foreach ($cart as $key => $item) {
          if ($item['product']['id'] == $request->product['id']) {
            if ($item['quantity'] > 1) {
              $cart[$key]['quantity']--;
            } else {
              unset($cart[$key]);
            }
          }
        }
      }
    }

    session()->put('cart', $cart);
  }

  public function destroy(): void
  {
    session()->put('cart', []);
  }

  public function checkIfInCart($cart, $product)
  {
    foreach ($cart as $item) {
      if ($item['product'] === $product) {
        return true;
      }
    }
    return false;
  }
}
