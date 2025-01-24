<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\NovofonApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GateController extends Controller
{
    /**
     * Открытие ворот
     *
     * @param Request           $request
     * @param NovofonApiService $novofonApiService
     *
     * @return JsonResponse
     */
    public function openGate(Request $request, NovofonApiService $novofonApiService): JsonResponse
    {
        $gate = $request->input('gate');
        $result = $novofonApiService->checkGateAccess($gate);

        return response()->json(['message' => $result['success'] ? 'Ворота открываются' : 'Ошибка'], $result['success'] ? 200 : 403);
    }
}
