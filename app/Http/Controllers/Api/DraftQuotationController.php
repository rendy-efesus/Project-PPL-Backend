<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DraftQuotation;

class DraftQuotationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET LIST
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $data = DraftQuotation::with('customer')
            ->latest()
            ->get();

        return response()->json([
            'message' => 'List draft quotation',
            'data' => $data
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE (CREATE)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customer,id',
            'available_id' => 'nullable|integer',
            'flight_type' => 'required|in:oneway,roundtrip',
            'flight_schedule' => 'required|date',
            'flight_route' => 'required|string',
            'pax' => 'required|integer|min:1',
        ]);

        $data = $validated;
        $data['user_id'] = $request->user()->id;

        // sementara kosong
        $data['integrate_id'] = null;

        $quotation = DraftQuotation::create($data);

        return response()->json([
            'message' => 'Draft quotation berhasil dibuat',
            'data' => $quotation
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW DETAIL
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $data = DraftQuotation::with('customer')->find($id);

        if (! $data) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Detail draft quotation',
            'data' => $data
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $quotation = DraftQuotation::find($id);

        if (! $quotation) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'customer_id' => 'required|exists:customer,id',
            'available_id' => 'nullable|integer',
            'flight_type' => 'required|in:oneway,roundtrip',
            'flight_schedule' => 'required|date',
            'flight_route' => 'required|string',
            'pax' => 'required|integer|min:1',
        ]);

        $quotation->update($validated);

        return response()->json([
            'message' => 'Draft quotation berhasil diupdate',
            'data' => $quotation
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $quotation = DraftQuotation::find($id);

        if (! $quotation) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $quotation->delete();

        return response()->json([
            'message' => 'Draft quotation berhasil dihapus'
        ]);
    }
}
