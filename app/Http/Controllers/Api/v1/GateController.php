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
     * @param Request $request
     * @return JsonResponse
     */
    public function openGate(Request $request, NovofonApiService $novofonApiService): JsonResponse
    {
		$phoneNumber = config('services.gate.phone_number');
		$result = $novofonApiService->checkGateAccess($phoneNumber);
		
		return response()->json(['message' => $result['success'] ? 'Ворота открываются' : 'Ошибка'], $result['success'] ? 200 : 403);
        /*if (auth()->user()->houses()->whereHas('gates', fn($q) => $q->where('id', $gate->id))->exists()) {
            $result = $novofonApiService->checkGateAccess($gate->phone);
            return response()->json(['message' => $result ? 'Gate opened' : 'Access denied'], $result ? 200 : 403);
        }*/

        //return response()->json(['message' => 'Unauthorized'], 403);
    }
}
