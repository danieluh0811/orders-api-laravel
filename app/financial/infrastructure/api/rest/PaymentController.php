<?php

namespace App\Financial\Infrastructure\Api\Rest;

use App\Financial\Domain\Model\Payment;
use App\Financial\Domain\Services\PaymentService;
use App\Financial\Util\Helpers\PaymentResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentController
{
    private PaymentService $service;

    public function __construct(PaymentService $service)
    {
        $this->service = $service;
    }

    public function list()
    {
        $payments = $this->service->listPayments();
        return response()->json(
            PaymentResponseHelper::toArrayList($payments)
        );
    }

    public function findById(int $id)
    {
        $payment = $this->service->findById($id);

        return $payment
            ? response()->json(PaymentResponseHelper::toArray($payment))
            : response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
    }

    public function findByOrderId(int $orderId)
    {
        $payments = $this->service->findByOrderId($orderId);

        return response()->json(
            PaymentResponseHelper::toArrayList($payments)
        );
    }

    public function save(Request $request)
    {
        $payment = new Payment(
            id: null,
            orderId: $request->order_id,
            amount: $request->amount,
            status: null,
            externalTransactionId: $request->external_transaction_id
        );

        $created = $this->service->processPayment($payment);

        return response()->json(
            PaymentResponseHelper::toArray($created),
            Response::HTTP_CREATED
        );
    }

    public function update(Request $request)
    {
        $payment = new Payment(
            id: $request->payment_id,
            orderId: $request->order_id,
            amount: $request->amount,
            status: null,
            externalTransactionId: $request->external_transaction_id
        );

        $updated = $this->service->update($payment);

        return response()->json(
            PaymentResponseHelper::toArray($updated)
        );
    }

    public function delete(int $id)
    {
        $this->service->delete($id);
        return response()->noContent();
    }
}
