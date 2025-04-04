<?php

namespace App\Services\Gate\SendStrategies;

interface GateSendStrategyInterface
{
    public function send(int $phoneNumber): array;
}
