<?php

namespace Pigeon\Application\Services;

use DateTime;
use Pigeon\Application\Algorithms\BinarySearchIndexAlgorithm;
use Pigeon\Application\Requests\CreateNewOrderRequest;
use Pigeon\Domain\Exceptions\InvalidDeadlineException;
use Pigeon\Domain\Exceptions\NotFoundPigeonException;
use Pigeon\Domain\Orders\Abstracts\OrderServiceInterface;
use Pigeon\Domain\Orders\Abstracts\PigeonServiceInterface;
use Pigeon\Infrastructure\Constants\Time;

/**
 * Class CreateOrderService
 * @package Pigeon\Application\Services
 */
class CreateOrderService
{
    /** @var OrderServiceInterface  */
    private OrderServiceInterface $orderService;

    /** @var PigeonServiceInterface  */
    private PigeonServiceInterface $pigeonService;

    /**
     * CreateOrderService constructor.
     * @param OrderServiceInterface $orderService
     * @param PigeonServiceInterface $pigeonService
     */
    public function __construct(
        OrderServiceInterface $orderService,
        PigeonServiceInterface $pigeonService
    )
    {
        $this->orderService = $orderService;
        $this->pigeonService = $pigeonService;
    }

    /**
     * @param CreateNewOrderRequest $request
     * @throws InvalidDeadlineException
     * @throws NotFoundPigeonException
     */
    public function exec(CreateNewOrderRequest $request): void
    {
        if (! $this->isToday($request->getDeadline())) {
            throw new InvalidDeadlineException();
        }

        // We pick pigeon with no order to assign job
        $pigeonWithNoOrders = $this->pigeonService->getPigeonValidDistanceAndNoOrders($request->getDistance());
        $listPigeonId = [];
        if (! empty($pigeonWithNoOrders)) {
            foreach ($pigeonWithNoOrders as $pigeon) {
                $hours = round($request->getDistance() / $pigeon['speed'], 2);
                $orderCost = $pigeon['cost'] * $request->getDistance();
                $startTimeEstimation = $this->calculateStartTimeEstimation($request->getDeadline(), $hours);
                $listPigeonId[] = $pigeon['id'];

                if (! $this->isToday($startTimeEstimation)) {
                    continue;
                }

                $this->orderService->makeOrder(
                    $this->buildOrderData(
                        $pigeon,
                        $request->getDistance(),
                        $orderCost,
                        $request->getDeadline(),
                        $startTimeEstimation
                    )
                );

                return;
            }
        }

        $pigeons = $this->pigeonService->getPigeonExcludeListId($request->getDistance(), $listPigeonId);

        if (! $pigeons) {
            throw new NotFoundPigeonException();
        }

        foreach ($pigeons as $pigeon) {
            $hours = round($request->getDistance() / $pigeon['speed'], 2);
            $orderCost = $pigeon['cost'] * $request->getDistance();
            $startTimeEstimation = $this->calculateStartTimeEstimation($request->getDeadline(), $hours);
            $timeCanReadyNewOrder = $this->calculateTimeCanReadyForNewOrder($request->getDeadline(), $pigeon['downtime']);
            if (! $this->isToday($startTimeEstimation) || ! $this->isToday($timeCanReadyNewOrder)) {
                continue;
            }

            if ($this->isValidOrderTime($pigeon, $startTimeEstimation, $request->getDeadline())) {
                $this->orderService->makeOrder(
                    $this->buildOrderData(
                        $pigeon,
                        $request->getDistance(),
                        $orderCost,
                        $request->getDeadline(),
                        $startTimeEstimation
                    )
                );

                return;
            }
        }

        throw new NotFoundPigeonException();
    }

    /**
     * @param array $pigeon
     * @param DateTime $startTimeEstimation
     * @param DateTime $deadline
     * @return bool
     */
    private function isValidOrderTime(
        array $pigeon,
        DateTime $startTimeEstimation,
        DateTime $deadline
    ): bool
    {
        $listSortedTime = $this->orderService->getListOrderTimeOfPigeon($pigeon['id']);
        $startTime = clone $startTimeEstimation;
        $startTime->modify("-" . $pigeon['downtime'] . " hours");
        $startTime = $startTime->format(Time::FORMAT);
        $endTime = clone $deadline;
        $endTime->modify("+" . $pigeon['downtime'] . " hours");
        $endTime = $endTime->format(Time::FORMAT);

        $startIndex = BinarySearchIndexAlgorithm::findTheIndex($listSortedTime, $startTime);
        $endIndex = BinarySearchIndexAlgorithm::findTheIndex($listSortedTime, $endTime);

        if ($startIndex === -1 || $endIndex === -1) {
            return false;
        } elseif ($startIndex % 2 === 1 || $endIndex % 2 === 1) {
            return false;
        } elseif ($startIndex === $endIndex && $startIndex % 2 === 0) {
            return true;
        }

        return false;
    }

    /**
     * @param array $pigeon
     * @param int $distance
     * @param int $orderCost
     * @param DateTime $deadline
     * @param DateTime $startTimeEstimation
     * @return array
     */
    private function buildOrderData(
        array $pigeon,
        int $distance,
        int $orderCost,
        DateTime $deadline,
        DateTime $startTimeEstimation
    ): array
    {
        return [
            'pigeon_id' => $pigeon['id'],
            'order_date' => date(Time::FORMAT_DAY),
            'cost' => $orderCost,
            'deadline' => $deadline->format(Time::FORMAT),
            'distance' => $distance,
            'start_time_estimation' => $startTimeEstimation->format(Time::FORMAT)
        ];
    }

    /**
     * @param DateTime $deadline
     * @param $hours
     * @return DateTime
     */
    private function calculateTimeCanReadyForNewOrder(DateTime $deadline, $hours): DateTime
    {
        $endTime = clone $deadline;
        $endTime->modify("+" . $hours . " hours");

        return $endTime;
    }

    /**
     * @param DateTime $deadline
     * @param $hours
     * @return DateTime
     */
    private function calculateStartTimeEstimation(DateTime $deadline, $hours): DateTime
    {
        $time = clone $deadline;
        $estimate = explode('.', $hours);
        $minutes = (int) $estimate[0] * 60 + (int) $estimate[1];

        $startTimeEstimation = $time->modify('-' . $minutes . ' minutes');

        return $startTimeEstimation;
    }

    /**
     * @param DateTime $time
     * @return bool
     * @throws \Exception
     */
    private function isToday(DateTime $time): bool
    {
        $now = (new DateTime())->format(Time::FORMAT_DAY);
        $time = $time->format(Time::FORMAT_DAY);

        return $now === $time;
    }
}