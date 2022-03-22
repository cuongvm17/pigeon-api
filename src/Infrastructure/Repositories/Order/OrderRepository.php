<?php

namespace Pigeon\Infrastructure\Repositories\Order;

use Illuminate\Support\Facades\DB;
use Pigeon\Infrastructure\Constants\Time;
use Pigeon\Infrastructure\Repositories\AbstractRepository;

/**
 * Class OrderRepository
 * @package Pigeon\Infrastructure\Repositories\Order
 */
class OrderRepository extends AbstractRepository implements OrderRepositoryInterface
{
    /** @var string  */
    protected string $tableName = 'orders';

    /**
     * @param array $condition
     * @return array
     */
    public function getOrders(array $condition): array
    {
        $orders = DB::table($this->tableName)
            ->where($condition)
            ->get()
            ->toArray();

        if (! empty($orders)) {
            $orders = array_map(function($order) {
                return (array) $order;
            }, $orders);
        }

        return $orders;
    }

    /**
     * @param array $data
     */
    public function makeOrder(array $data): void
    {
        $this->insert($data);
    }

    /**
     * @param int $pigeonId
     * @return array
     * @throws \Exception
     */
    public function getListOrderTimeOfPigeon(int $pigeonId): array
    {
        $now = (new \DateTime())->format(Time::FORMAT_DAY);
        $data = DB::table($this->tableName)
            ->select('start_time_estimation', 'deadline')
            ->where([
                ['pigeon_id', '=', $pigeonId],
                ['order_date', '=', $now]
            ])
            ->get()
            ->toArray();

        $data = array_map(function($item) {
            return array_values((array) $item);
        }, $data);
        $data = call_user_func_array('array_merge', $data);
        sort($data);

        return $data;
    }
}