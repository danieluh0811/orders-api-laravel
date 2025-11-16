<?php

namespace App\Financial\Domain\Persistence;

use App\Financial\Domain\Model\Order;

interface OrderPersistence
{
    public function listOrders(): array;
 
    public function save(Order $order): Order;
 
    public function saveAll(array $orders): array;
   
    public function update(Order $order): void;
   
    public function findById(int $id): ?Order;
  
    public function deleteById(int $id): void;
   
    public function findByStatus(string $status): array;
}
