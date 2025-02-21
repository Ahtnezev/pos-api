<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Models\CartDetail;
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
     * Display a listing of the resource.
    */
    public function salesHistory(string $storeId)
    {
        $vendor = Auth::user();

        // verificamos que el vendedor tenga la tienda
        $store = Store::where('id', $storeId)->where('vendor_id', $vendor->id)->firstOrFail();

        $sales = CartDetail::whereHas('cart', function ($query) {
                $query->where('pending', false);
            })
            ->whereHas('product', function ($query) use ($storeId) {
                $query->where('store_id', $storeId);
            })
            ->with(['cart.user', 'product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($sales);
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
