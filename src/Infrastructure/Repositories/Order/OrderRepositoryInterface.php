<?php

namespace Pigeon\Infrastructure\Repositories\Order;

/**
 * Interface OrderRepositoryInterface
 * @package Pigeon\Infrastructure\Repositories\Order
 */
interface OrderRepositoryInterface
{
    /**
     * @param array $condition
     * @return array
     */
    public function getOrders(array $condition): array;

    /**
     * @param array $data
     */
    public function makeOrder(array $data): void;

    /**
     * @param int $pigeonId
     * @return array
     */
    public function getListOrderTimeOfPigeon(int $pigeonId): array;
}