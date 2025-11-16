<?php

namespace App\Financial\Domain\Model;

class Payment
{
    public function __construct(
        public ?int $id,
        public int $orderId,
        public float $amount,
        public ?PaymentStatus $status = null, 
        public ?string $externalTransactionId = null,
    ) {}

    public function isSuccess(): bool
    {
        return $this->status?->isSuccess() ?? false;
    }

    public function isFailed(): bool
    {
        return $this->status?->isFailed() ?? false;
    }
}
