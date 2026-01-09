<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with(['items.product.images', 'items.merchant'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Verify ownership
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load([
            'items.product.images',
            'items.merchant',
            'merchantOrders.merchant',
            'merchantOrders.items.product.images',
        ]);

        return view('orders.show', [
            'order' => $order,
        ]);
    }
}
