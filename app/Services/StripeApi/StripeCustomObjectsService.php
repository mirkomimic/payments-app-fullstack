<?php

namespace App\Services\StripeApi;

use App\Models\User;

class StripeCustomObjectsService
{
  private array $subscriptions;

  public function __construct(
    protected SubscriptionsService $subscriptionService,
    protected ProductsService $productsService,
    protected PricesService $pricesService
  ) {
  }

  public function getSubscriptions(string $user_stripe_id): array
  {
    $object = [];

    foreach ($this->subscriptionService->list($user_stripe_id) as $subscription) {

      $object['subscription'] = $subscription;
      $object['product'] = $this->productsService->retrieve($subscription->plan->product);
      $object['price'] = $this->pricesService->retrieve($subscription->plan->id);

      $this->subscriptions[] = $object;
    }

    return $this->subscriptions;
  }

  public function getCashierSubscriptions(User $user): array
  {
    $object = [];

    foreach ($user->subscriptions as $subscription) {
      $object['subscription'] = $subscription;
      $object['price'] = $this->pricesService->retrieve($subscription->stripe_price);
      $object['product'] = $this->productsService->retrieve($object['price']->product);

      $this->subscriptions[] = $object;
    }

    return $this->subscriptions;
  }
}
