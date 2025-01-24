<?php

namespace App\Services;

use Exception;
use Novofon_API\Api;

class NovofonApiService
{
    private Api $client;
    private array $gatePhoneNumbers;
    private string $callerNumber;

    public function __construct()
    {
        $this->gatePhoneNumbers = config('services.gate.phone_numbers');
		$this->callerNumber = config('services.novofon.caller_number');
        $this->client = new Api(config('services.novofon.key'), config('services.novofon.secret'));
    }

    /**
     * Отправка запроса на проверку номера для ворот
     *
     * @param int $gate
     *
     * @return array Ответ от API
     */
    public function checkGateAccess(int $gate): array
    {
        try {
            $phoneNumber = $this->gatePhoneNumbers[$gate] ?? null;

            if (!$phoneNumber) {
                return [
                    'success' => false,
                    'message' => "Неизвестный идентификатор ворот: {$gate}",
                    'data' => [],
                ];
            }

            return [
                'success' => true,
                'message' => 'Ворота открываются',
                'data' => $this->client->requestChecknumber($this->callerNumber, $phoneNumber, 1),
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
