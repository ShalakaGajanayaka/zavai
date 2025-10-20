<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->withCount('items')
            ->get();

        return Inertia::render('Frontend/Orders/Index', [
            'orders' => $orders
        ]);
    }

    public function show(Order $order)
    {
        // === ඉතාම වැදගත් ආරක්ෂක පියවරක් ===
        // මේ බලන order එක, දැනට log වෙලා ඉන්න user ගේම එකක්ද කියලා check කරනවා.
        // එහෙම නැත්නම්, "403 Forbidden" error එකක් පෙන්වනවා.
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Order එකේ items සහ ඒ items වලට අදාල product details එකපාර load කරගන්නවා (Eager Loading)
        $order->load('items.product');

        return Inertia::render('Frontend/Orders/Show', [
            'order' => $order
        ]);
    }
}
