<?php

namespace App\Services;

use App\Clients\NovofonClient;
use Exception;

class GateService implements GateServiceInterface
{
    private array $gatePhoneNumbers;

    /**
     * @param NovofonClient $novofonClient
     */
    public function __construct(
        private readonly NovofonClient $novofonClient,
    )
    {
        $this->gatePhoneNumbers = config('services.gate.phone_numbers');
    }

    /**
     * Открытие ворот.
     *
     * @param int $gateId
     * @return array
     */
    public function openGate(int $gateId): array
    {
        try {
            $phoneNumber = $this->gatePhoneNumbers[$gateId] ?? null;

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
