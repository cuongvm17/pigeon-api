<?php

namespace Pigeon\Application\Algorithms;

/**
 * Class BinarySearchIndexAlgorithm
 * @package Pigeon\Application\Algorithms
 */
class BinarySearchIndexAlgorithm
{
    /**
     * @param array $array
     * @param $key
     * @return int
     */
    public static function findTheIndex(array $array, $key): int
    {
        $low = 0;
        $high = count($array) - 1;

        while ($low <= $high) {
            $mid = (int) floor(($low + $high) / 2);

            if ($array[$mid] == $key) {
                return -1;
            } elseif ($array[$mid] < $key) {
                $low = $mid + 1;
            } else {
                $high = $mid - 1;
            }
        }

        return $high + 1;
    }
}