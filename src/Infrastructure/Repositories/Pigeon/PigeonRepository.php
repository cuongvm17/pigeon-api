<?php

namespace Pigeon\Infrastructure\Repositories\Pigeon;

use Illuminate\Support\Facades\DB;
use Pigeon\Infrastructure\Constants\Time;
use Pigeon\Infrastructure\Repositories\AbstractRepository;

/**
 * Class PigeonRepository
 * @package Pigeon\Infrastructure\Repositories\Pigeon
 */
class PigeonRepository extends AbstractRepository implements PigeonRepositoryInterface
{
    /** @var string  */
    protected string $tableName = 'pigeons';

    /**
     * @param int $distance
     * @param array $listId
     * @return array
     */
    public function getPigeons(int $distance, array $listId): array
    {
        $pigeons = DB::table($this->tableName)
            ->where([['range', '>=', $distance]])
            ->whereNotIn('id', $listId)
            ->get()
            ->toArray();

        if (! empty($pigeons)) {
            $pigeons = array_map(function($pigeon) {
                return (array) $pigeon;
            }, $pigeons);
        }

        return $pigeons;
    }

    /**
     * @param int $distance
     * @return array
     * @throws \Exception
     */
    public function getPigeonsWithNoOrders(int $distance): array
    {
        $now = (new \DateTime())->format(Time::FORMAT_DAY);
        $pigeons = DB::table($this->tableName)
            ->whereNotExists(function($query) use ($now) {
                $query->select(DB::raw(1))
                    ->from('orders')
                    ->whereRaw("orders.pigeon_id = pigeons.id AND orders.order_date = '{$now}'");
            })
            ->where([
                [$this->tableName . '.range', '>=', $distance]
            ])
            ->get()
            ->toArray();

        if (! empty($pigeons)) {
            $pigeons = array_map(function($pigeon) {
                return (array) $pigeon;
            }, $pigeons);
        }

        return $pigeons;
    }
}