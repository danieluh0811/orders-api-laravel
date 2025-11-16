<?php

namespace App\Financial\Infrastructure\Db\Daos;

use App\Financial\Infrastructure\Db\Entities\OrderEntity;

class OrderRepository
{
    public function findAll()
    {
        return OrderEntity::with('payments')->get();
    }

    public function saveEntity(array $data): OrderEntity
    {
        return OrderEntity::create($data);
    }

    public function updateEntity(int $orderId, array $data): void
    {
        OrderEntity::where('order_id', $orderId)->update($data);
    }

    public function findEntityById(int $id): ?OrderEntity
    {
        return OrderEntity::with('payments')->find($id);
    }

    public function softDelete(int $id): void
    {
        OrderEntity::where('order_id', $id)->update(['is_deleted' => 1]);
    }

    public function findByStatusEntity(string $status)
    {
        return OrderEntity::where('status', $status)
            ->where('is_deleted', 0)
            ->with('payments')
            ->get();
    }
}
