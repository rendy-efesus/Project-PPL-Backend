<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use App\Helpers\ResponseHelper;

class AirportController extends Controller
{
    public function index()
    {
        $airport = Airport::select('id', 'code', 'name')
            ->orderBy('id', 'asc')
            ->get();

            if ($airport->isEmpty()) {
            return ResponseHelper::success([], 'No aircraft found');
        }

        return ResponseHelper::success($airport, 'List airport');
    }
}
