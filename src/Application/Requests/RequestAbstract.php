<?php

namespace Pigeon\Application\Requests;

use InvalidArgumentException;

/**
 * Class RequestAbstract
 * @package Pigeon\Application\Requests
 */
abstract class RequestAbstract
{
    /**
     * RequestAbstract constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->validate($data);
        if (! $this->map($data)) {
            throw new InvalidArgumentException('The mapping failed!');
        }
    }

    /**
     * @return array
     */
    public abstract function rules(): array;

    /**
     * @return array
     */
    public abstract function messages(): array;

    /**
     * @param array $data
     * @return mixed
     */
    public abstract function validate(array $data);

    /**
     * @param array $data
     * @return bool
     */
    public abstract function map(array  $data): bool;
}