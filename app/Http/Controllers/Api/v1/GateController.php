<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\GateServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GateController extends Controller
{
    /**
     * @param GateServiceInterface $gateService
     */
    public function __construct(
        private readonly GateServiceInterface $gateService
    ) {
    }

    /**
     * Открытие ворот
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function openGate(Request $request): JsonResponse
    {
        $gateId = $request->input('gate');

        $result = $this->gateService->openGate($gateId);

        return response()->json(
            ['message' => $result['message']],
            $result['success'] ? JsonResponse::HTTP_OK : JsonResponse::HTTP_FORBIDDEN
        );
    }
}
