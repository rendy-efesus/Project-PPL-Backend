<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET LIST CUSTOMER
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $customers = Customer::latest()->get();

        return response()->json([
            'message' => 'List customer',
            'data' => $customers
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE (ADD CUSTOMER)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:50',
            'contact_person' => 'required|string|max:50',
            'email' => 'nullable|email|max:50|unique:customer,email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:50',
            'province' => 'nullable|string|max:50',
            'postal_code' => 'nullable|numeric',
            'country' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $customer = Customer::create([
            // 'user_id' => auth()->id(),
            'user_id' => $request->user()->id,
            ...$validated
        ]);

        return response()->json([
            'message' => 'Customer berhasil ditambahkan',
            'data' => $customer
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW DETAIL CUSTOMER
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $customer = Customer::find($id);

        if (! $customer) {
            return response()->json([
                'message' => 'Customer tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Detail customer',
            'data' => $customer
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE CUSTOMER
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (! $customer) {
            return response()->json([
                'message' => 'Customer tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'company' => 'required|string|max:50',
            'contact_person' => 'required|string|max:50',
            'email' => 'nullable|email|max:50|unique:customer,email,' . $id,
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:50',
            'province' => 'nullable|string|max:50',
            'postal_code' => 'nullable|numeric',
            'country' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $customer->update($validated);

        return response()->json([
            'message' => 'Customer berhasil diupdate',
            'data' => $customer
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE CUSTOMER
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (! $customer) {
            return response()->json([
                'message' => 'Customer tidak ditemukan'
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'message' => 'Customer berhasil dihapus'
        ]);
    }
}
