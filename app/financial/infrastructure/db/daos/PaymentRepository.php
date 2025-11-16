<?php

namespace App\Financial\Infrastructure\Db\Daos;

use App\Financial\Infrastructure\Db\Entities\PaymentEntity;

class PaymentRepository
{
    public function findAll()
    {
        return PaymentEntity::all();
    }

    public function saveEntity(array $data): PaymentEntity
    {
        return PaymentEntity::create($data);
    }

    public function updateEntity(int $id, array $data): void
    {
        PaymentEntity::where('payment_id', $id)->update($data);
    }

    public function findEntityById(int $id): ?PaymentEntity
    {
        return PaymentEntity::find($id);
    }

    public function findByOrderIdEntity(int $orderId)
    {
        return PaymentEntity::where('order_id', $orderId)
            ->where('is_deleted', 0)
            ->get();
    }

    public function softDelete(int $id): void
    {
        PaymentEntity::where('payment_id', $id)->update(['is_deleted' => 1]);
    }
}
