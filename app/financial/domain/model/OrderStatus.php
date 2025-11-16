<?php

namespace App\Financial\Domain\Model;

use App\Financial\Domain\Enum\OrderStatusEnum;

class OrderStatus
{
    public function __construct(
        private OrderStatusEnum $value
    ) {}

    public static function pending(): self
    {
        return new self(OrderStatusEnum::PENDING);
    }

    public static function paid(): self
    {
        return new self(OrderStatusEnum::PAID);
    }

    public static function failed(): self
    {
        return new self(OrderStatusEnum::FAILED);
    }

    public static function from(string $value): self
    {
        return new self(OrderStatusEnum::from($value));
    }

    public function value(): string
    {
        return $this->value->value;
    }

    public function isPending(): bool
    {
        return $this->value === OrderStatusEnum::PENDING;
    }

    public function isPaid(): bool
    {
        return $this->value === OrderStatusEnum::PAID;
    }

    public function isFailed(): bool
    {
        return $this->value === OrderStatusEnum::FAILED;
    }
}
