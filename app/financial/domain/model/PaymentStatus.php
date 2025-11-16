<?php

namespace App\Financial\Domain\Model;

use App\Financial\Domain\Enum\PaymentStatusEnum;

class PaymentStatus
{
    private PaymentStatusEnum $value;

    private function __construct(PaymentStatusEnum $value)
    {
        $this->value = $value;
    }

    public static function success(): self
    {
        return new self(PaymentStatusEnum::SUCCESS);
    }

    public static function failed(): self
    {
        return new self(PaymentStatusEnum::FAILED);
    }

    public static function from(string $value): self
    {
        return new self(PaymentStatusEnum::from($value));
    }

    public function value(): string
    {
        return $this->value->value;
    }

    public function isSuccess(): bool
    {
        return $this->value === PaymentStatusEnum::SUCCESS;
    }

    public function isFailed(): bool
    {
        return $this->value === PaymentStatusEnum::FAILED;
    }
}
