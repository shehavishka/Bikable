<?php
require_once('vendor/autoload.php');

$stripe = new \Stripe\StripeClient("sk_test_51N7HnvSFTAxNgg5fQhRzX14azolYyZNQ6TOtrjR9FInl9IiedAYMiHST0cJLtLAFX4xvAMGPzaDnM08MxG3adPKP00COVME3dY");

$product = $stripe->products->create([
  'name' => 'Starter Subscription',
  'description' => '$12/Month subscription',
]);
echo "Success! Here is your starter subscription product id: " . $product->id . "\n";

$price = $stripe->prices->create([
  'unit_amount' => 1200,
  'currency' => 'usd',
  'recurring' => ['interval' => 'month'],
  'product' => $product['id'],
]);
echo "Success! Here is your premium subscription price id: " . $price->id . "\n";

?>