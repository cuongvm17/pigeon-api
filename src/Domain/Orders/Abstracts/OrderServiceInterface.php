<?php

namespace Pigeon\Domain\Orders\Abstracts;

use DateTime;

/**
 * Interface OrderServiceInterface
 * @package Pigeon\Domain\Orders\Abstracts
 */
interface OrderServiceInterface
{
    /**
     * @param int $pigeonId
     * @param DateTime $orderDate
     * @return array
     */
    public function getPigeonOrdersByDate(int $pigeonId, DateTime $orderDate): array;

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