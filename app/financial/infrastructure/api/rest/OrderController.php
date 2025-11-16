<?php

namespace App\Financial\Infrastructure\Api\Rest;

use App\Financial\Domain\Services\OrderService;
use App\Financial\Util\Helpers\OrderResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController
{
    private OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function list()
    {
        $orders = $this->service->listOrders();

        return response()->json(
            OrderResponseHelper::toArrayList($orders)
        );
    }

    public function findById(int $id)
    {
        $order = $this->service->findById($id);

        return $order
            ? response()->json(OrderResponseHelper::toArray($order))
            : response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
    }

    public function save(Request $request)
    {
        $order = $this->service->create(
            customerName: $request->customer_name,
            totalAmount: $request->total_amount,
            status: $request->status,
            createdBy: $request->created_by ?? 0,
            updatedBy: $request->updated_by ?? 0
        );

        return response()->json(
            OrderResponseHelper::toArray($order),
            Response::HTTP_CREATED
        );
    }

    public function update(Request $request)
    {
        $order = $this->service->updateOrder(
            orderId: $request->order_id,
            customerName: $request->customer_name,
            totalAmount: $request->total_amount,
            status: $request->status,
            updatedBy: $request->updated_by ?? 0,
            isDeleted: $request->is_deleted ?? 0
        );

        return response()->json(
            OrderResponseHelper::toArray($order)
        );
    }

    public function delete(int $id)
    {
        $this->service->delete($id);
        return response()->noContent();
    }

    public function findByStatus(string $status)
    {
        $orders = $this->service->findByStatus($status);

        return response()->json(
            OrderResponseHelper::toArrayList($orders)
        );
    }
}
