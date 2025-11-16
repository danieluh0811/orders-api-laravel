<?php

namespace Tests\Feature;

use App\Financial\Util\Helpers\OrderApiInit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FailedPaymentTest extends TestCase
{

/*
|--------------------------------------------------------------------------
| FailedPaymentTest
|--------------------------------------------------------------------------
| Requerimientos cumplidos:
|
| ✔ Cada intento de pago debe contactar una API externa simulada.
| ✔ Si un pago falla, el pedido debe quedar en estado "failed".
| ✔ Un pedido en estado "failed" debe permitir nuevos intentos de pago.
| ✔ Cada intento incrementa el contador paymentAttempts.
| ✔ Si un nuevo intento es exitoso, el pedido debe pasar a estado "paid".
|
| Este test verifica:
| - Que un pago fallido marca correctamente la orden como "failed".
| - Que el contador de intentos aumente.
| - Que la orden permita un segundo intento.
| - Que un segundo intento exitoso cambie el estado a "paid".
|
*/

    use RefreshDatabase;
    

    public function test_failed_payment_marks_order_failed_and_allows_retry()
    {
        OrderApiInit::reset();

        $order = $this->postJson('/api/orders', [
            'customer_name' => 'Pedro',
            'total_amount'  => 200
        ])->json();

        // PRIMER INTENTO: failed
        OrderApiInit::setMode('failed');

        $this->postJson('/api/payments', [
            'order_id' => $order['orderId'],
            'amount'   => 200
        ]);

        $o1 = $this->getJson("/api/orders/{$order['orderId']}")->json();

        $this->assertEquals('failed', $o1['status']);
        $this->assertEquals(1, $o1['paymentAttempts']);

        // SEGUNDO INTENTO: → success
        OrderApiInit::setMode('success');

        $this->postJson('/api/payments', [
            'order_id' => $order['orderId'],
            'amount'   => 200
        ]);

        $o2 = $this->getJson("/api/orders/{$order['orderId']}")->json();

        $this->assertEquals('paid', $o2['status']);
        $this->assertEquals(2, $o2['paymentAttempts']);
    }
}
