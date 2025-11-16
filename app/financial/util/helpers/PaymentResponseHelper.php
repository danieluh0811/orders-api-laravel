<?php

namespace App\Financial\Util\Helpers;

use App\Financial\Domain\Model\Payment;

class PaymentResponseHelper
{
    public static function toArray(Payment $payment): array
    {
        return [
            'id'                     => $payment->id,
            'orderId'                => $payment->orderId,
            'amount'                 => $payment->amount,
            'status'                 => $payment->status?->value(),
            //'externalTransactionId'  => $payment->externalTransactionId,
        ];
    }

    public static function toArrayList(array $payments): array
    {
        return array_map(fn(Payment $p) => self::toArray($p), $payments);
    }
}
