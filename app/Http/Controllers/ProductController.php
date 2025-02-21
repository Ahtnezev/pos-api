<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request, Store $store)
    {
        $validatedData = $request->validated();

        return $store->products()->create($validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        return !$product
            ? response()->json(['message' => 'Whoops!, product not found'], 404)
            : $product;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->only('name', 'price', 'stock'));

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $productId)
    {
        $product = Product::find($productId);

        if (!$product)
            return response()->json(['message' => 'Whoops!, product not found'], 404);

        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }
}
