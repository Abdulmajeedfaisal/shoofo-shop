<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use App\Models\Merchant;
use App\Models\ShippingSetting;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        $cart = auth()->user()->getOrCreateCart();
        $cart->load('items.product.images', 'items.product.merchant');
        
        // حساب الشحن لكل تاجر
        $shippingDetails = $this->calculateShippingDetails($cart);
        $subtotal = $cart->getTotalAmount();
        
        return view('cart.index', [
            'cart' => $cart,
            'items' => $cart->items,
            'subtotal' => $subtotal,
            'shippingTotal' => $shippingDetails['total'],
            'shippingByMerchant' => $shippingDetails['byMerchant'],
            'total' => $subtotal + $shippingDetails['total'],
            'itemsCount' => $cart->getItemsCount(),
        ]);
    }

    /**
     * Calculate shipping details for cart
     */
    private function calculateShippingDetails($cart): array
    {
        if ($cart->items->isEmpty()) {
            return ['total' => 0, 'byMerchant' => []];
        }

        $itemsByMerchant = $cart->items->groupBy(fn ($item) => $item->product->merchant_id);
        $shippingByMerchant = [];
        $totalShipping = 0;

        foreach ($itemsByMerchant as $merchantId => $items) {
            $merchant = Merchant::find($merchantId);
            $merchantSubtotal = $items->sum(fn ($item) => $item->getSubtotal());
            $shippingCost = ShippingSetting::calculateShipping($merchantSubtotal, $merchant);
            
            $shippingByMerchant[$merchantId] = [
                'merchant' => $merchant,
                'subtotal' => $merchantSubtotal,
                'shipping' => $shippingCost,
            ];
            $totalShipping += $shippingCost;
        }

        return [
            'total' => $totalShipping,
            'byMerchant' => $shippingByMerchant,
        ];
    }

    /**
     * Add a product to cart
     */
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1|max:' . $product->quantity,
        ]);

        $quantity = $request->input('quantity', 1);

        // Check if product is in stock
        if (!$product->isInStock()) {
            return back()->with('error', __('cart.out_of_stock'));
        }

        // Check if requested quantity is available
        if ($quantity > $product->quantity) {
            return back()->with('error', __('cart.insufficient_stock'));
        }

        $cart = auth()->user()->getOrCreateCart();

        // Check if product already in cart
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $quantity;
            
            if ($newQuantity > $product->quantity) {
                return back()->with('error', __('cart.insufficient_stock'));
            }

            $cartItem->update([
                'quantity' => $newQuantity,
                'price' => $product->getCurrentPrice(),
            ]);
        } else {
            // Add new item
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->getCurrentPrice(),
            ]);
        }

        return back()->with('success', __('cart.added_successfully'));
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, CartItem $cartItem)
    {
        // Verify ownership
        if ($cartItem->cart->user_id !== auth()->id()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cartItem->product->quantity,
        ]);

        $cartItem->update([
            'quantity' => $request->quantity,
            'price' => $cartItem->product->getCurrentPrice(),
        ]);

        // إذا كان الطلب AJAX، أرجع البيانات المحدثة
        if ($request->ajax() || $request->wantsJson()) {
            $cart = $cartItem->cart;
            $cart->load('items.product.merchant');
            
            $shippingDetails = $this->calculateShippingDetails($cart);
            $subtotal = $cart->getTotalAmount();
            
            return response()->json([
                'success' => true,
                'item' => [
                    'id' => $cartItem->id,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->getSubtotal(),
                    'subtotal_formatted' => number_format($cartItem->getSubtotal(), 2),
                ],
                'cart' => [
                    'subtotal' => $subtotal,
                    'subtotal_formatted' => number_format($subtotal, 2),
                    'shipping' => $shippingDetails['total'],
                    'shipping_formatted' => $shippingDetails['total'] > 0 ? number_format($shippingDetails['total'], 2) : null,
                    'total' => $subtotal + $shippingDetails['total'],
                    'total_formatted' => number_format($subtotal + $shippingDetails['total'], 2),
                    'items_count' => $cart->getItemsCount(),
                ],
            ]);
        }

        return back()->with('success', __('cart.updated_successfully'));
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request, CartItem $cartItem)
    {
        // Verify ownership
        if ($cartItem->cart->user_id !== auth()->id()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            abort(403);
        }

        $cart = $cartItem->cart;
        $cartItem->delete();

        // إذا كان الطلب AJAX، أرجع البيانات المحدثة
        if ($request->ajax() || $request->wantsJson()) {
            $cart->load('items.product.merchant');
            
            $shippingDetails = $this->calculateShippingDetails($cart);
            $subtotal = $cart->getTotalAmount();
            
            return response()->json([
                'success' => true,
                'cart' => [
                    'subtotal' => $subtotal,
                    'subtotal_formatted' => number_format($subtotal, 2),
                    'shipping' => $shippingDetails['total'],
                    'shipping_formatted' => $shippingDetails['total'] > 0 ? number_format($shippingDetails['total'], 2) : null,
                    'total' => $subtotal + $shippingDetails['total'],
                    'total_formatted' => number_format($subtotal + $shippingDetails['total'], 2),
                    'items_count' => $cart->getItemsCount(),
                    'is_empty' => $cart->items->isEmpty(),
                ],
            ]);
        }

        return back()->with('success', __('cart.removed_successfully'));
    }

    /**
     * Clear all items from cart
     */
    public function clear()
    {
        $cart = auth()->user()->cart;
        
        if ($cart) {
            $cart->items()->delete();
        }

        return back()->with('success', __('cart.cleared_successfully'));
    }
}
