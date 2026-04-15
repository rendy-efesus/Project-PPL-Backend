<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aircraft;
use App\Helpers\ResponseHelper;

class AircraftController extends Controller
{
    public function index()
    {
        // $aircraft = Aircraft::select('id', 'name')->get();
        $aircraft = Aircraft::select('id', 'name')
            ->orderBy('id', 'asc')
            ->get();

        if ($aircraft->isEmpty()) {
            return ResponseHelper::success([], 'No aircraft found');
        }

        return ResponseHelper::success($aircraft, 'List aircraft');
    }
}
