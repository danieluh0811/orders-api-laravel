<?php

namespace App\Financial\Domain\Services;

use App\Financial\Domain\Model\Payment;
use App\Financial\Domain\Model\PaymentStatus;
use App\Financial\Domain\Model\OrderStatus;
use App\Financial\Domain\Persistence\PaymentPersistence;
use App\Financial\Domain\Persistence\OrderPersistence;
use App\Financial\External\PaymentExternalApi;
class PaymentService
{
    private PaymentPersistence $paymentPersistence;
    private OrderPersistence $orderPersistence;
    private PaymentExternalApi $externalApi;

    public function __construct(
        PaymentPersistence $paymentPersistence,
        OrderPersistence $orderPersistence,
        PaymentExternalApi $externalApi
    ) {
        $this->paymentPersistence = $paymentPersistence;
        $this->orderPersistence  = $orderPersistence;
        $this->externalApi       = $externalApi;
    }
    public function listPayments(): array
    {
        return $this->paymentPersistence->listPayments();
    }

    public function processPayment(Payment $payment): Payment
    {
       $order = $this->orderPersistence->findById($payment->orderId);

      if (!$order) {
        throw new \Exception("Order not found");
      }

      if ($order->status->isPaid()) {
        throw new \Exception("Order already paid. No more payments allowed.");
      }

      $external = $this->externalApi->process(
        amount: $payment->amount,
        reference: $payment->externalTransactionId ?? uniqid('ref_')
      );

      $payment->status = $external['success']
        ? PaymentStatus::success()
        : PaymentStatus::failed();

      $payment->externalTransactionId = $external['external_id'];

      $savedPayment = $this->paymentPersistence->save($payment);

      if ($payment->isSuccess()) {
        $order->markAsPaid();
     } else {
        $order->markAsFailed();
     }

       $this->orderPersistence->update($order);

       return $savedPayment;
    }


    public function update(Payment $payment): Payment
    {
        $this->paymentPersistence->update($payment);
        return $payment;
    }

    public function findById(int $id): ?Payment
    {
        return $this->paymentPersistence->findById($id);
    }

    public function findByOrderId(int $orderId): array
    {
        return $this->paymentPersistence->findByOrderId($orderId);
    }

    public function delete(int $id): void
    {
        $this->paymentPersistence->deleteById($id);
    }
    
}
