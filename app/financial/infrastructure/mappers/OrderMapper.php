<?php

namespace App\Financial\Infrastructure\Mappers;

use App\Financial\Domain\Model\Order;
use App\Financial\Domain\Model\OrderStatus;
use App\Financial\Infrastructure\Db\Entities\OrderEntity;

class OrderMapper
{
    public function toDomain(OrderEntity $entity): Order
    {
        $order = new Order(
            orderId: $entity->order_id,
            customerName: $entity->customer_name,
            totalAmount: (float) $entity->total_amount,
            status: OrderStatus::from($entity->status),
            payments: [], 
            createdBy: $entity->created_by,
            updatedBy: $entity->updated_by,
            isDeleted: $entity->is_deleted
        );

        if ($entity->relationLoaded('payments')) {
            $order->payments = array_map(
                fn($paymentEntity) => PaymentMapper::toDomain($paymentEntity),
                $entity->payments->all()
            );
        }

        return $order;
    }

    public function toDomainList($entities): array
    {
        return array_map(
            fn($entity) => $this->toDomain($entity),
            $entities->all()
        );
    }

    public function toEntityArray(Order $order): array
    {
        return [
            'customer_name' => $order->customerName,
            'total_amount'  => $order->totalAmount,
            'status'        => $order->status->value(),
            'created_by'    => $order->createdBy,
            'updated_by'    => $order->updatedBy,
            'is_deleted'    => $order->isDeleted,
        ];
    }
}
