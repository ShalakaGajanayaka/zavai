<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get(); // අලුත්ම orders උඩින් එන්න

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        // 1. එවන ලද status එක වලංගු එකක්දැයි බලනවා
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'processing', 'completed', 'cancelled'])],
        ]);

        // 2. Order එකේ status එක update කරලා save කරනවා
        $order->status = $validated['status'];
        $order->save();

        // 3. සාර්ථක පණිවිඩයක් සමග ආපහු redirect කරනවා
        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order status updated successfully!');
    }
}
