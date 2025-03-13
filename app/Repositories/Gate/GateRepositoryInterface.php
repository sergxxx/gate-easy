<?php

namespace App\Repositories\Gate;

interface GateRepositoryInterface
{
    public function all(): array;

    public function getPhoneNumberByGateId(int $gateId): ?string;
}
