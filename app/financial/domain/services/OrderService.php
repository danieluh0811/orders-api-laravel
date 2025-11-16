<?php

namespace App\Financial\Domain\Services;

use App\Financial\Domain\Model\Order;
use App\Financial\Domain\Model\OrderStatus;
use App\Financial\Domain\Persistence\OrderPersistence;

class OrderService
{
    private OrderPersistence $persistence;

    public function __construct(OrderPersistence $persistence)
    {
        $this->persistence = $persistence;
    }

    public function listOrders(): array
    {
        return $this->persistence->listOrders();
    }

    public function create(
        string $customerName,
        float $totalAmount,
        ?string $status,
        int $createdBy,
        int $updatedBy
    ): Order {
        $order = new Order(
            orderId: null,
            customerName: $customerName,
            totalAmount: $totalAmount,
            status: OrderStatus::from($status ?? 'pending'),
            payments: [],
            createdBy: $createdBy,
            updatedBy: $updatedBy,
            isDeleted: 0
        );

        return $this->persistence->save($order);
    }

    public function updateOrder(
        int $orderId,
        string $customerName,
        float $totalAmount,
        string $status,
        int $updatedBy,
        int $isDeleted = 0
    ): Order {
        $order = new Order(
            orderId: $orderId,
            customerName: $customerName,
            totalAmount: $totalAmount,
            status: OrderStatus::from($status),
            payments: [],
            createdBy: 0,
            updatedBy: $updatedBy,
            isDeleted: $isDeleted
        );

        $this->persistence->update($order);

        return $order;
    }

    public function findById(int $id): ?Order
    {
        return $this->persistence->findById($id);
    }

    public function delete(int $id): void
    {
        $this->persistence->deleteById($id);
    }

    public function findByStatus(string $status): array
    {
        return $this->persistence->findByStatus($status);
    }
}
