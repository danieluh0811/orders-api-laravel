<?php

namespace App\Financial\Domain\Persistence;

use App\Financial\Domain\Model\Payment;

interface PaymentPersistence
{
    public function save(Payment $payment): Payment;
 
    public function update(Payment $payment): void;

    public function findById(int $id): ?Payment;

    public function findByOrderId(int $orderId): array;

    public function listPayments(): array;

    public function deleteById(int $id): void;
}
