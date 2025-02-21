<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CartRequest $request)
    {
        return Cart::create([
            'client_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'pending' => true
        ]);
    }

    /**
     *
    */
    public function checkout()
    {
        $cart = Cart::where('client_id', Auth::id())
            ->where('pending', true)
                ->get();

        Cart::where('client_id', Auth::id())
            ->update(['pending' => false]);

        return response()->json(['message' => 'Checkout completed', 'items' => $cart]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $cartId)
    {
        //
    }
}
