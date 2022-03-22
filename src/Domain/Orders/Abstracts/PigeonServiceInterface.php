<?php

namespace Pigeon\Domain\Orders\Abstracts;

/**
 * Interface PigeonServiceInterface
 * @package Pigeon\Domain\Orders\Abstracts
 */
interface PigeonServiceInterface
{
    /**
     * @param int $distance
     * @param array $listId
     * @return array
     */
    public function getPigeonExcludeListId(int $distance, array $listId): array;

    /**
     * @param int $distance
     * @return array
     */
    public function getPigeonValidDistanceAndNoOrders(int $distance): array;
}