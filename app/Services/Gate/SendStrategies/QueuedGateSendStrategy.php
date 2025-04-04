<?php

namespace App\Services\Gate\SendStrategies;

use App\Jobs\OpenGateJob;

/**
 * Стратегия открытия ворот сразу через очередь
 */
class QueuedGateSendStrategy implements GateSendStrategyInterface
{
    /**
     * @param int $phoneNumber
     *
     * @return array
     */
    public function send(int $phoneNumber): array
    {
        dispatch(new OpenGateJob($phoneNumber));

        return [
            'success' => true,
            'message' => 'Ворота открываются',
        ];
    }
}
