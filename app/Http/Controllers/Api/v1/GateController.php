<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\Gate\GateServiceInterface;
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
     * Список ворот
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getGates(Request $request): JsonResponse
    {
        return response()->json($this->gateService->getGateList());
    }

    /**
     * Открытие ворот
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function open(Request $request): JsonResponse
    {
        $gateId = $request->input('gate');

        $result = $this->gateService->openGate($gateId);

        /*$result = [
            'success' => 1,
            'message' => 'Ворота открываются',
        ];*/

        return response()->json(
            ['message' => $result['message']],
            $result['success'] ? JsonResponse::HTTP_OK : JsonResponse::HTTP_FORBIDDEN
        );
    }
}
