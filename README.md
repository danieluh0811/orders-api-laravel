# Orders API – Evaluación Técnica

Esta API permite gestionar **pedidos** y **pagos**, cumpliendo con los siguientes requisitos:

- Crear pedidos con nombre del cliente, monto total y estado inicial **pending**.
- Registrar pagos asociados a un pedido existente.
- Cada intento de pago siempre usa el monto total del pedido.
- Al registrar un pago, se realiza una llamada a una **API externa simulada**.
- Si el pago es exitoso, el pedido pasa a estado **paid**.
- Si el pago falla, el pedido pasa a estado **failed**.
- Un pedido en estado "failed" puede recibir nuevos intentos de pago.
- Se puede **listar pedidos**, mostrando:
  - estado actual,
  - intentos de pago,
  - pagos asociados.

---

## Tecnologías utilizadas
- PHP 8.x
- Laravel 10
- PHPUnit para tests
- Xdebug (opcional para debugging)
- Beeceptor como API mock externa
- sqlite

---

## Arquitectura del proyecto

El proyecto está organizado siguiendo una estructura ligera basada en **DDD (Domain-Driven Design)**:

