<?php

namespace App\Services\Gate;

interface GateServiceInterface
{
    public function openGate(int $gateId): array;
    public function getGateList(): array;
}
