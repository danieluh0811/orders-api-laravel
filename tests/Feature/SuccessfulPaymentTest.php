<?php

namespace Tests\Feature;

use App\Financial\External\PaymentExternalApi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


/*
|--------------------------------------------------------------------------
| SuccessfulPaymentTest
|--------------------------------------------------------------------------
| Requerimientos cumplidos:
|
| ✔ Registrar pagos asociados a un pedido existente.
| ✔ Cada pago debe consultarse con una API externa simulada.
| ✔ Si el pago es exitoso, el pedido debe pasar a estado "paid".
| ✔ El API externa debe permitir devolver un external_id.
|
| Este test verifica:
| - Que un pago marcado como exitoso actualiza correctamente el pedido.
| - Que el estado final del pedido sea "paid".
| - Que el flujo completo de creación de pedido → pago → actualización funcione.
|
*/

class SuccessfulPaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function payment_success_marks_order_as_paid()
    {
        $order = $this->postJson('/api/orders', [
            'customer_name' => 'Daniel',
            'total_amount'  => 150
        ])->json();

        $this->mock(PaymentExternalApi::class, function ($mock) {
            $mock->shouldReceive('process')
                 ->andReturn(['success' => true, 'external_id' => 'ext_123']);
        });

        $payment = $this->postJson('/api/payments', [
            'order_id'               => $order['orderId'],
            'amount'                 => 150,
            'external_transaction_id'=> 'abc'
        ]);

        $payment->assertStatus(201);

        $orderUpdated = $this->getJson("/api/orders/{$order['orderId']}")
                             ->json();

        $this->assertEquals('paid', $orderUpdated['status']);
    }
}
