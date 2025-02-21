<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\CartDetails;
use App\Models\Product;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
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

    private function hasStockProduct(Request $request): int {
        $error_type = 0;
        $product = Product::findOrFail($request->product_id);

        if (!$product)
            $error_type = 1;

        if ($product->stock <= 0)
            $error_type = 2;

        $totalStock = ($product->stock - $request->quantity);
        if ($totalStock < 0)
            $error_type = 3;

        return $error_type;
    }

    /**
     * Agregar info al carrito
     */
    public function store(CartRequest $request)
    {
        $hasStock = $this->hasStockProduct($request);

        switch ($hasStock) {
            case 1:
                return response()->json(['message' => 'Whoops!, product not found'], 404);
                break;
            case 2:
                return response()->json(['message' => 'Whoops!, product out of stock'], 404);
                break;
            case 3:
                return response()->json(['message' => 'Whoops!, stock isn\'t enough'], 404);
                break;
            default:
                break;
        }

        $cart = Cart::with('details')->where('client_id', Auth::id())
            ->where('pending', true)
                ->first();

        if (!$cart)
            return $this->storeNewCart($request);

        $cart_id = $cart->id;
        $this->storeNewCartDetail($request, $cart_id);

        return response()->json(['message' => 'Product added to cart'], 200);
    }

    /**
     * Almacena un nuevo carrito
    */
    private function storeNewCart(Request $request): void {
        $cart = Cart::create([
            'client_id' => Auth::id(),
            'pending' => true
        ]);

        $cart_id = $cart->id;

        $this->storeNewCartDetail($request, $cart_id);
    }

    /**
     * Almacena un nuevo detalle de carrito
    */
    private function storeNewCartDetail(Request $request, int $cardId): void {
        CartDetails::create([
            'cart_id' => $cardId,
            'client_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        $this->updateProductStock($request);
    }

    /**
     * Una vez se confirme la acción realizar checkout
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
        $cart = Cart::find($cartId);
        if (!$cart)
            return response()->json(['message' => 'Whoops!, cart not found'], 404);

        // $this->authorize('delete', $cart);

        $cart->delete();

        return response()->json(['message' => 'Cart deleted']);
    }

    /**
     * Actualiza el stock del producto
    */
    private function updateProductStock($request): void {
        $product = Product::find($request->product_id);
        $product->stock -= $request->quantity;
        $product->save();
    }

    /**
     * Delete a item from cart
    */
    public function destroyDetail(string $cartDetailId)
    {
        $cart_detail = CartDetails::find($cartDetailId);
        if (!$cart_detail)
            return response()->json(['message' => 'Whoops!, cart item not found'], 404);

        // $this->authorize('delete', $cart);

        $cart_detail->product()->update([
            'stock' => $cart_detail->product->stock + $cart_detail->quantity
        ]);

        $cart_detail->delete();

        return response()->json(['message' => 'Cart item deleted']);
    }
}
