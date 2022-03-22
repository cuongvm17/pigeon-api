<?php

namespace Pigeon\Infrastructure\Repositories\Pigeon;

/**
 * Interface PigeonRepositoryInterface
 * @package Pigeon\Infrastructure\Repositories\Pigeon
 */
interface PigeonRepositoryInterface
{
    /**
     * @param int $distance
     * @param array $listId
     * @return array
     */
    public function getPigeons(int $distance, array $listId): array;

    /**
     * @param int $distance
     * @return array
     */
    public function getPigeonsWithNoOrders(int $distance): array;
}