<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AircraftAvailable;
use App\Helpers\ResponseHelper;

class AircraftAvailableController extends Controller
{
    public function index()
    {
        $data = AircraftAvailable::select(
            'id',
            'aircraft_id',
            'available_start',
            'available_end'
        )
            ->with([
                'aircraft:id,name'
            ])
            ->get();

        if ($data->isEmpty()) {
            return ResponseHelper::success([], 'No available aircraft');
        }

        return ResponseHelper::success($data, 'List available aircraft');
    }
}
