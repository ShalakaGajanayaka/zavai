<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);

        // Cart එක හිස් නම්, checkout page එකට යන්න නොදී ආපහු හරවනවා
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items before proceeding to checkout.');
        }

        return Inertia::render('Frontend/Checkout/Index', [
            'cartItems' => $cartItems
        ]);
    }

    public function store(Request $request)
    {
        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('home');
        }

        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $order = DB::transaction(function () use ($validatedData, $cartItems) {

            $totalAmount = 0;
            foreach ($cartItems as $id => $details) {
                $totalAmount += $details['price'] * $details['quantity'];
            }

            $orderData = array_merge($validatedData, [
                'user_id' => auth()->id(), // Log වුණ user ගේ ID එක (guest නම් null)
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);
            $order = Order::create($orderData);

            foreach ($cartItems as $id => $details) {
                $order->items()->create([
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('checkout.success', ['order' => $order->id])
            ->with('success', 'Your order has been placed successfully!');
    }

    public function success(Order $order)
    {
        return Inertia::render('Frontend/Checkout/Success', [
            'order' => $order
        ]);
    }
}
