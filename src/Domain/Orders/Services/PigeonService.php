<?php

namespace Pigeon\Domain\Orders\Services;

use Pigeon\Domain\Orders\Abstracts\PigeonServiceInterface;
use Pigeon\Infrastructure\Repositories\Pigeon\PigeonRepositoryInterface;

/**
 * Class PigeonService
 * @package Pigeon\Domain\Orders\Services
 */
class PigeonService implements PigeonServiceInterface
{
    /** @var PigeonRepositoryInterface  */
    private PigeonRepositoryInterface $pigeonRepository;

    /**
     * PigeonService constructor.
     * @param PigeonRepositoryInterface $pigeonRepository
     */
    public function __construct(
        PigeonRepositoryInterface $pigeonRepository
    )
    {
        $this->pigeonRepository = $pigeonRepository;
    }

    /**
     * @param int $distance
     * @param array $listId
     * @return array
     */
    public function getPigeonExcludeListId(int $distance, array $listId): array
    {
        return $this->pigeonRepository->getPigeons($distance, $listId);
    }

    /**
     * @param int $distance
     * @return array
     */
    public function getPigeonValidDistanceAndNoOrders(int $distance): array
    {
        return $this->pigeonRepository->getPigeonsWithNoOrders($distance);
    }
}