<?php

namespace Pigeon\Application\Requests;

use DateTime;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

/**
 * Class CreateNewOrderRequest
 * @package Pigeon\Application\Requests
 */
class CreateNewOrderRequest extends RequestAbstract
{
    /** @var int */
    private int $distance;
    /** @var DateTime */
    private DateTime $deadline;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'distance' => 'required|numeric|gt:0',
            'deadline' => 'string|date_format:Y-m-d H:i:s'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'required' => 'Trường :attribute bắt buộc.',
            'string' => 'Trường :attribute phải ở dạng chuỗi.',
            'numeric' => 'Trường :attribute phải ở dạng số.',
            'gt' => 'Trường :attribute phải lớn hơn 0.',
            'date_format' => 'Trường :attribute phải có định dạng Y-m-d H:i:s'
        ];
    }

    /**
     * @param array $data
     * @return mixed|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(array $data)
    {
        $validator = Validator::make(
            $data,
            $this->rules(),
            $this->messages()
        );

        $validator->validate();
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function map(array $data): bool
    {
        $this->distance = $data['distance'];
        $this->deadline = new DateTime($data['deadline']);

        return true;
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @return DateTime
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @param DateTime $deadline
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }
}