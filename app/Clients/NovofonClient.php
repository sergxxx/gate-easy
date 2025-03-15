<?php

namespace App\Clients;

use Novofon_API\Api;

/**
 * Клиент API Novofon https://github.com/novofon/user-api-v1
 */
class NovofonClient
{
    private Api $api;
    private string $callerNumber;

    public function __construct()
    {
        $this->api = new Api(config('services.novofon.key'), config('services.novofon.secret'));
        $this->callerNumber = config('services.novofon.caller_number');
    }

    /**
     * Отправка запроса на проверку номера для доступа к воротам
     *
     * @param string $phoneNumber
     *
     * @return array
     */
    public function requestCheckNumber(string $phoneNumber) : array
    {
        return $this->api->requestChecknumber($this->callerNumber, $phoneNumber, 1)->toArray();
    }
}
