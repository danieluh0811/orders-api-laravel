<?php

namespace App\Financial\Infrastructure\Mappers;

use App\Financial\Domain\Model\Payment;
use App\Financial\Domain\Model\PaymentStatus;
use App\Financial\Infrastructure\Db\Entities\PaymentEntity;

class PaymentMapper
{
    public static function toDomain(PaymentEntity $entity): Payment
    {
        return new Payment(
            id: $entity->payment_id,
            orderId: $entity->order_id,
            amount: (float) $entity->amount,
            status: PaymentStatus::from($entity->status),
            externalTransactionId: $entity->external_transaction_id,
        );
    }


    public static function toEntityArray(Payment $payment): array
    {
        return [
            'payment_id'              => $payment->id,
            'order_id'                => $payment->orderId,
            'amount'                  => $payment->amount,
            'status'                  => $payment->status->value(),
            'external_transaction_id' => $payment->externalTransactionId,
            'is_deleted'              => 0,
        ];
    }

    public static function toDomainList(iterable $collection): array
    {
        $result = [];

        foreach ($collection as $entity) {
            $result[] = self::toDomain($entity);
        }

        return $result;
    }
}
