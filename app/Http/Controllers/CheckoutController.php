<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Merchant;
use App\Models\MerchantOrder;
use App\Models\ShippingSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display checkout page
     */
    public function index()
    {
        $cart = auth()->user()->getOrCreateCart();
        $cart->load('items.product.images', 'items.product.merchant');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', __('checkout.empty_cart'));
        }

        // حساب الشحن لكل تاجر
        $shippingDetails = $this->calculateShippingDetails($cart);

        return view('checkout.index', [
            'cart' => $cart,
            'items' => $cart->items,
            'subtotal' => $cart->getTotalAmount(),
            'shippingTotal' => $shippingDetails['total'],
            'shippingByMerchant' => $shippingDetails['byMerchant'],
            'total' => $cart->getTotalAmount() + $shippingDetails['total'],
            'itemsCount' => $cart->getItemsCount(),
            'user' => auth()->user(),
        ]);
    }

    /**
     * Calculate shipping details for cart
     */
    private function calculateShippingDetails($cart): array
    {
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
     * Process the order
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_country' => 'required|string|max:100',
            'shipping_postal_code' => 'nullable|string|max:20',
            'payment_method' => 'required|in:cod,credit_card,bank_transfer',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = auth()->user()->getOrCreateCart();
        $cart->load('items.product.merchant');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', __('checkout.empty_cart'));
        }

        // Check stock availability
        foreach ($cart->items as $item) {
            if (!$item->product->isInStock() || $item->quantity > $item->product->quantity) {
                return back()->with('error', __('checkout.product_unavailable'));
            }
        }

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = $cart->getTotalAmount();
            $shippingDetails = $this->calculateShippingDetails($cart);
            $tax = 0;
            $shipping = $shippingDetails['total'];
            $total = $subtotal + $tax + $shipping;

            $orderNumber = Order::generateOrderNumber();

            // Create main order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $orderNumber,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
                'shipping_name' => $request->shipping_name,
                'shipping_email' => $request->shipping_email,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_country' => $request->shipping_country,
                'shipping_postal_code' => $request->shipping_postal_code,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'notes' => $request->notes,
            ]);

            // Group cart items by merchant
            $itemsByMerchant = $cart->items->groupBy(fn ($item) => $item->product->merchant_id);

            $merchantIndex = 1;
            foreach ($itemsByMerchant as $merchantId => $merchantItems) {
                $merchantSubtotal = $merchantItems->sum(fn ($item) => $item->getSubtotal());
                $merchantShipping = $shippingDetails['byMerchant'][$merchantId]['shipping'] ?? 0;

                // Create merchant order (sub-order)
                $merchantOrder = MerchantOrder::create([
                    'order_id' => $order->id,
                    'merchant_id' => $merchantId,
                    'sub_order_number' => MerchantOrder::generateSubOrderNumber($orderNumber, $merchantIndex),
                    'status' => 'pending',
                    'subtotal' => $merchantSubtotal,
                    'shipping_cost' => $merchantShipping,
                ]);

                // Create order items for this merchant
                foreach ($merchantItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'merchant_order_id' => $merchantOrder->id,
                        'product_id' => $item->product_id,
                        'merchant_id' => $merchantId,
                        'product_name' => $item->product->name,
                        'product_name_ar' => $item->product->name_ar,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'subtotal' => $item->getSubtotal(),
                    ]);

                    // Decrease product stock
                    $item->product->decrement('quantity', $item->quantity);
                }

                $merchantIndex++;
            }

            // Clear cart
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('checkout.success', $order)
                ->with('success', __('checkout.order_placed'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', __('checkout.order_error'));
        }
    }

    /**
     * Order success page
     */
    public function success(Order $order)
    {
        // Verify ownership
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product.images', 'items.merchant', 'merchantOrders.merchant']);

        return view('checkout.success', [
            'order' => $order,
        ]);
    }
}
