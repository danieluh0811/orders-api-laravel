<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{

    
/*
|--------------------------------------------------------------------------
| CreateOrderTest
|--------------------------------------------------------------------------
| Requerimientos cumplidos:
|
| ✔ Crear pedidos con nombre del cliente y monto total.
| ✔ Todo pedido nuevo debe iniciar con estado "pending".
| ✔ Validar que la API responda correctamente al crear un pedido.
|
| Este test verifica que:
| - El endpoint /api/orders crea un pedido correctamente.
| - Los campos customerName, totalAmount y status se guarden bien.
| - El estado inicial del pedido siempre sea "pending".
|
*/

    use RefreshDatabase;

    /** @test */
    public function can_create_order_with_pending_status()
    {
        $response = $this->postJson('/api/orders', [
            'customer_name' => 'Juan Perez',
            'total_amount'  => 100
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'customerName' => 'Juan Perez',
                     'totalAmount'  => 100,
                     'status'       => 'pending',
                 ]);
    }
}
