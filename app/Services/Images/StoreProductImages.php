<?php

namespace App\Services\Images;


class StoreProductImages
{
  public static function store($request): array | string
  {
    if ($request->hasFile('images')) {
      $i = 0;
      $imagesNames = [];
      foreach ($request->images as $img) {
        $img->store('images/products/', 'public');
        $imagesNames[] = $img->hashName();
        $i++;
      }

      return $imagesNames;
    }

    return '';
  }
}
