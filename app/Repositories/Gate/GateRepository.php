<?php

namespace App\Repositories\Gate;

use App\Services\config;

/**
 * Работа с репозиторием
 */
class GateRepository implements GateRepositoryInterface
{
    private $gates;

    public function __construct()
    {
        $this->gates = config('services.gate.phone_numbers');
    }

    /**
     * Список ворот
     * @return array
     */
    public function all() : array
    {
        return $this->gates;
    }

    /**
     * Получение номера ворот по id
     * @param int $gateId
     *
     * @return string|null
     */
    public function getPhoneNumberByGateId(int $gateId) : ?string
    {
        $gateIds = array_column($this->gates, 'id');
        $index = array_search($gateId, $gateIds);

        return $index !== false ? $this->gates[$index]['phone'] : null;
    }
}
