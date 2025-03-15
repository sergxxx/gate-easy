<?php

namespace App\Services\Gate;

use Exception;
use App\Clients\NovofonClient;
use App\Repositories\Gate\GateRepository;

/**
 * Сервис для управления воротами
 */
class GateService implements GateServiceInterface
{
    /**
     * @param NovofonClient  $novofonClient
     * @param GateRepository $gateRepository
     */
    public function __construct(
        private readonly NovofonClient $novofonClient,
        private readonly GateRepository $gateRepository
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

            $response = $this->novofonClient->requestCheckNumber($phoneNumber);

            return [
                'success' => true,
                'message' => 'Ворота открываются',
                'data' => $response,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Ошибка открытия ворот',
            ];
        }
    }
}
