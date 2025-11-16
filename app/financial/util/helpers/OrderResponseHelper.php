<?php

namespace App\Financial\Util\Helpers;

use App\Financial\Domain\Model\Order;

class OrderResponseHelper
{
    public static function toArray(Order $order): array
    {
        return [
            'orderId'         => $order->orderId,
            'customerName'    => $order->customerName,
            'totalAmount'     => $order->totalAmount,
            'status'          => $order->status->value(),
            'paymentAttempts' => count($order->payments),
            'payments'        => array_map(
                fn($p) => [
                    'id'    => $p->id,
                    'amount'=> $p->amount,
                    'status'=> $p->status?->value(),
                ],
                $order->payments
            ),
        ];
    }

    public static function toArrayList(array $orders): array
    {
        return array_map(fn($o) => self::toArray($o), $orders);
    }
}
