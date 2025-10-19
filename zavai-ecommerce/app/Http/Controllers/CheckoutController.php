<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

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
}
