<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Store::with('vendor')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();

        return Store::create(['name' => $validatedData['name'], 'vendor_id' => Auth::id()]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Store $store)
    {
        return $store->load('products');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Store $store)
    {
        // $this->authorize('update', $store);
        // \Gate::authorize('update', $store);
        $store->update($request->only('name'));

        return $store;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $storeId)
    {
        $store = Store::find($storeId);
        if (!$store)
            return response()->json(['message' => 'Whoops!, store not found'], 404);

        // $this->authorize('delete', $store);
        $store->delete();

        return response()->json(['message' => 'Store deleted']);
    }
}
