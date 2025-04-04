<?php

namespace App\Services\Gate;

use Exception;
use App\Repositories\Gate\GateRepository;
use App\Services\Gate\SendStrategies\GateSendStrategyInterface;

/**
 * Сервис для управления воротами
 * Стратегия открытия ворот (через очередь или сразу через API) задаётся через конфиг env GATE_SEND_QUEUE
 */
readonly class GateService implements GateServiceInterface
{
    /**
     * @param GateRepository            $gateRepository
     * @param GateSendStrategyInterface $sendStrategy
     */
    public function __construct(
        private GateRepository $gateRepository,
        private GateSendStrategyInterface $sendStrategy
    ) {
    }

    /**
     * Список ворот
     *
     * @return array[]
     */
    public function getGateList() : array
    {
        return $this->gateRepository->all();
    }

    /**
     * Открытие ворот
     *
     *
     * @param int $gateId
     * @return array
     */
    public function openGate(int $gateId) : array
    {
        try {
            $phoneNumber = $this->gateRepository->getPhoneNumberByGateId($gateId);

            if (!$phoneNumber) {
                return [
                    'success' => false,
                    'message' => "Ворота с номером {$gateId} не обнаружены",
                ];
            }

            return $this->sendStrategy->send($phoneNumber);
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Ошибка открытия ворот',
            ];
        }
    }
}
