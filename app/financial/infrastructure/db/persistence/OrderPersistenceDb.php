<?php

namespace App\Financial\Infrastructure\Db\Persistence;

use App\Financial\Domain\Model\Order;
use App\Financial\Domain\Persistence\OrderPersistence;
use App\Financial\Infrastructure\Db\Daos\OrderRepository;
use App\Financial\Infrastructure\Mappers\OrderMapper;

class OrderPersistenceDb implements OrderPersistence
{
    private OrderRepository $repository;
    private OrderMapper $mapper;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
        $this->mapper = new OrderMapper();
    }

    public function listOrders(): array
    {
        $entities = $this->repository->findAll();
        return $this->mapper->toDomainList($entities);
    }

    public function save(Order $order): Order
    {
        $data   = $this->mapper->toEntityArray($order);
        $entity = $this->repository->saveEntity($data);

        return $this->mapper->toDomain($entity);
    }

    public function saveAll(array $orders): array
    {
        $result = [];

        foreach ($orders as $order) {
            $result[] = $this->save($order);
        }

        return $result;
    }

    public function update(Order $order): void
    {
        $data = $this->mapper->toEntityArray($order);

        $this->repository->updateEntity($order->orderId, $data);
    }

    public function findById(int $id): ?Order
    {
        $entity = $this->repository->findEntityById($id);
        return $entity ? $this->mapper->toDomain($entity) : null;
    }

    public function findByStatus(string $status): array
    {
        $entities = $this->repository->findByStatusEntity($status);
        return $this->mapper->toDomainList($entities);
    }

    public function deleteById(int $id): void
    {
        $this->repository->softDelete($id);
    }
}
