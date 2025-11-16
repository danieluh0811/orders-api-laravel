<?php

namespace Tests\Feature;

use App\Financial\Util\Helpers\OrderApiInit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListOrdersTest extends TestCase
{

/*
|--------------------------------------------------------------------------
| ListOrdersTest
|--------------------------------------------------------------------------
| Requerimientos cumplidos:
|
| ✔ Listar todos los pedidos almacenados.
| ✔ Mostrar el estado actual del pedido (pending/failed/paid).
| ✔ Incluir la cantidad de intentos de pago realizados (paymentAttempts).
| ✔ Incluir la lista de pagos asociados al pedido.
| ✔ Reflejar correctamente los resultados de la API externa simulada.
|
| Este test verifica:
| - Que un pedido con un intento de pago fallido aparezca correctamente en el listado.
| - Que la orden tenga 1 intento registrado.
| - Que el estado sea "failed" después del intento fallido.
| - Que la lista de pagos incluya ese único pago fallido.
|
*/

    use RefreshDatabase;

    /** @test */
    public function lists_orders_with_payments_and_attempts()
    {
        OrderApiInit::reset();

        $order = $this->postJson('/api/orders', [
            'customer_name' => 'Mario',
            'total_amount'  => 300
        ])->json();

        OrderApiInit::setMode('failed');

        $this->postJson('/api/payments', [
            'order_id' => $order['orderId'],
            'amount'   => 300
        ]);

        $list = $this->getJson('/api/orders')->json();

        $this->assertCount(1, $list);
        $this->assertEquals(1, $list[0]['paymentAttempts']);
        $this->assertEquals('failed', $list[0]['status']);
        $this->assertCount(1, $list[0]['payments']);
    }
}
