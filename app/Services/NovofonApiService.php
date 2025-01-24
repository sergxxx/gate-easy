<?php

namespace App\Services;

use Novofon_API\Api;
use Exception;

class NovofonApiService
{
    private Api $client;

    public function __construct()
    {
		$this->callerNumber = config('services.novofon.caller_number');
        $this->client = new Api(config('services.novofon.key'), config('services.novofon.secret'));
    }

    /**
     * Отправка запроса на проверку номера для ворот
     *
     * @param string $phoneNumber Номер телефона
     * @return array Ответ от API
     */
    public function checkGateAccess(string $phoneNumber): array
    {
        try {
            $response = $this->client->requestChecknumber($this->callerNumber, $phoneNumber, 1);

            return [
                'success' => true,
                'message' => 'Ворота открываются',
                'data' => $response,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
