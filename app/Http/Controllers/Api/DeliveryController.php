<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DeliveryService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    use ApiResponseTrait;

    protected DeliveryService $deliveryService;

    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    public function nearest(Request $request)
    {
        $deliveries = $this->deliveryService->getNearestDeliveries(
            $request->user()
        );

        return $this->successResponse(
            'Nearest delivery representatives retrieved successfully.',
            $deliveries
        );
    }
}