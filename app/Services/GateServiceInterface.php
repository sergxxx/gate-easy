<?php

namespace App\Services;

interface GateServiceInterface
{
    public function openGate(int $gateId): array;
}
