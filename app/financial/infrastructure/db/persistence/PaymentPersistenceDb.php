<?php

namespace App\Financial\Infrastructure\Db\Persistence;

use App\Financial\Domain\Model\Payment;
use App\Financial\Domain\Persistence\PaymentPersistence;
use App\Financial\Infrastructure\Db\Daos\PaymentRepository;
use App\Financial\Infrastructure\Mappers\PaymentMapper;

class PaymentPersistenceDb implements PaymentPersistence
{
    private PaymentRepository $repository;
    private PaymentMapper $mapper;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
        $this->mapper = new PaymentMapper();
    }

    public function listPayments(): array
    {
        $entities = $this->repository->findAll();
        return $this->mapper->toDomainList($entities);
    }

    public function save(Payment $payment): Payment
    {
        $data   = $this->mapper->toEntityArray($payment);
        $entity = $this->repository->saveEntity($data);

        return $this->mapper->toDomain($entity);
    }

    public function update(Payment $payment): void
    {
        $data = $this->mapper->toEntityArray($payment);
        $this->repository->updateEntity($payment->id, $data);
    }

    public function findById(int $id): ?Payment
    {
        $entity = $this->repository->findEntityById($id);
        return $entity ? $this->mapper->toDomain($entity) : null;
    }

    public function findByOrderId(int $orderId): array
    {
        $entities = $this->repository->findByOrderIdEntity($orderId);
        return $this->mapper->toDomainList($entities);
    }

    public function deleteById(int $id): void
    {
        $this->repository->softDelete($id);
    }
}
