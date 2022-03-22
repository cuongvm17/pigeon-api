<?php

namespace Pigeon\Domain\Orders\Services;

use DateTime;
use Pigeon\Domain\Orders\Abstracts\OrderServiceInterface;
use Pigeon\Infrastructure\Repositories\Order\OrderRepositoryInterface;

/**
 * Class OrderService
 * @package Pigeon\Domain\Orders\Services
 */
class OrderService implements OrderServiceInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;

    /**
     * OrderService constructor.
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository
    )
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param int $pigeonId
     * @param DateTime $orderDate
     * @return array
     */
    public function getPigeonOrdersByDate(int $pigeonId, DateTime $orderDate): array
    {
        return $this->orderRepository->getOrders([
            ['pigeon_id', '=', $pigeonId],
            ['order_date', '=', $orderDate]
        ]);
    }

    /**
     * @param array $data
     */
    public function makeOrder(array $data): void
    {
        $this->orderRepository->makeOrder($data);
    }

    /**
     * @param int $pigeonId
     * @return array
     */
    public function getListOrderTimeOfPigeon(int $pigeonId): array
    {
        return $this->orderRepository->getListOrderTimeOfPigeon($pigeonId);
    }
}