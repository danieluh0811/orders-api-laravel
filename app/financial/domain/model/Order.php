<?php

namespace App\Financial\Domain\Model;

class Order
{
    public function __construct(
        public ?int $orderId,
        public string $customerName,
        public float $totalAmount,
        public OrderStatus $status,
        public array $payments = [],
        public int $createdBy = 0,
        public int $updatedBy = 0,
        public int $isDeleted = 0,
    ) {}

    public static function create(string $customerName, float $totalAmount): self
    {
        return new self(
            orderId: null,
            customerName: $customerName,
            totalAmount: $totalAmount,
            status: OrderStatus::pending(),
            payments: [],
            createdBy: 0,
            updatedBy: 0,
            isDeleted: 0
        );
    }

    public function markAsPaid(): void
    {
        $this->status = OrderStatus::paid();
    }

    public function markAsFailed(): void
    {
        $this->status = OrderStatus::failed();
    }

    public function canBePaid(): bool
    {
        return !$this->status->isPaid();
    }
}
