<?php

namespace App\Services\Gate\SendStrategies;

use App\Clients\NovofonClient;
use Exception;

/**
 * Стратегия открытия ворот сразу через API novofon
 */
class ImmediateGateSendStrategy implements GateSendStrategyInterface
{
    public function __construct(private NovofonClient $novofonClient) {}

    /**
     * @param int $phoneNumber
     *
     * @return array
     */
    public function send(int $phoneNumber): array
    {
        try {
            $this->novofonClient->requestCheckNumber($phoneNumber);

            return [
                'success' => true,
                'message' => 'Ворота открываются',
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Ошибка при открытии ворот',
            ];
        }
    }
}
