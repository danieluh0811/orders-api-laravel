## Orders API – Evaluación Técnica

Esta API permite gestionar pedidos y pagos. Los pedidos se crean con nombre de cliente, monto total y un estado inicial “pending”. Cada vez que se intenta registrar un pago, la API realiza una llamada a una API externa simulada usando Beeceptor. Dependiendo de la URL configurada, el pago puede resultar exitoso o fallido: si el servicio mock devuelve éxito, el pedido cambia de estado a “paid”; si devuelve error, el pedido pasa a “failed”, permitiendo nuevos intentos posteriores. Cada intento siempre utiliza el monto total del pedido y queda registrado en la tabla de pagos. La API también permite listar todos los pedidos mostrando su estado actual, la cantidad de intentos y los detalles de cada pago realizado.

Esta evaluación utiliza un mock externo configurable mediante Beeceptor. Para probar pagos exitosos o fallidos solo es necesario cambiar la URL del mock. Se utilizó la siguiente estructura de configuración:

{
    "paymentMode": "success",
    "paymentUrls": {
        "success": "https://order-api-success.free-beeceptor.com",
        "failed": "https://order-api-failed.free-beeceptor.com"
    }
}


Si se quiere simular un pago exitoso se usa la URL de “success”, por ejemplo:

PAYMENT_GATEWAY_URL=https://order-api-success.free.beeceptor.com


Y si se quiere simular un pago fallido se usa:

PAYMENT_GATEWAY_URL=https://order-api-failed.free.beeceptor.com


Con este cambio simple la API permite validar ambos escenarios (éxito y fallo) sin modificar el código.

---

## Tecnologías utilizadas

- PHP 8.2.12
- Laravel 12.38.1
- Composer 2.x
- PHPUnit 10.x (incluido en vendor/bin/phpunit)
- SQLite 3.x (usado por PDO SQLite de PHP)
- Xdebug 3.3.2 (opcional para debugging)
- Beeceptor como servicio mock de API externa

---

## Arquitectura del proyecto

El proyecto está organizado siguiendo una estructura ligera basada en **DDD (Domain-Driven Design)**:


## Guía de levantamiento

# Clonar el repositorio
git clone https://github.com/tu-usuario/orders-api-laravel.git
cd orders-api-laravel

# Instalar dependencias
composer install

# Copiar archivo .env y configurar SQLite
cp .env.example .env

# Ajustar .env
# DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite
# DB_FOREIGN_KEYS=true

# Generar clave de la app
php artisan key:generate

# Ejecutar migraciones
php artisan migrate

# Levantar el servidor
php artisan serve

# Ejecuta los tests
php artisan test

# Endpoints de la API

La API expone los siguientes endpoints organizados por recursos: Orders y Payments.

# Orders

Base path: /api/orders

Método	Endpoint	Descripción
# GET	/api/orders	Lista todos los pedidos con su estado, intentos y pagos.
# POST	/api/orders	Crea un nuevo pedido.

# Payments

Base path: /api/payments

Método	Endpoint	Descripción 
# GET /api/payments/order/{orderId} Lista pagos asociados a un pedido.
# POST	/api/payments	Registra un nuevo intento de pago y procesa la transacción.
