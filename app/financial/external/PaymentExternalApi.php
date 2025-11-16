<?php

namespace App\Financial\External;

use App\Financial\Util\Helpers\OrderApiInit;
use Illuminate\Support\Facades\Http;

class PaymentExternalApi
{
  public function process(float $amount, string $reference): array
  {
    $config = OrderApiInit::get();

    $mode = $config['paymentMode'];

    $url = $config['paymentUrls'][$mode];

    $response = Http::get($url);

    return [
        'success'     => $response->json('success') == true,
        'external_id' => $response->json('external_id') ?? null
    ];
   }
}
