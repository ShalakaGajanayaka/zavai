<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order #{{ $order->id }} - Zavai Admin</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f3f4f6;
            margin: 0;
        }

        .header {
            background-color: white;
            padding: 15px 40px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content {
            padding: 40px;
            max-width: 1000px;
            margin: auto;
        }

        h1,
        h2,
        h3 {
            color: #1f2937;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .detail-item {
            margin-bottom: 10px;
        }

        .detail-item strong {
            display: block;
            color: #6b7280;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f9fafb;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2><a href="{{ route('admin.dashboard') }}" style="text-decoration: none; color: inherit;">Zavai Admin Panel</a></h2>
        <a href="{{ route('admin.orders.index') }}">&larr; Back to Orders</a>
    </div>

    <div class="content">
        {{-- Success Message --}}
        @if (session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
        @endif

        <h1>Order Details: #{{ $order->id }}</h1>

        <div class="grid">
            <div class="card">
                <h3>Customer Details</h3>
                <div class="detail-item"><strong>Name:</strong> {{ $order->customer_name }}</div>
                <div class="detail-item"><strong>Email:</strong> {{ $order->customer_email }}</div>
                <div class="detail-item"><strong>Phone:</strong> {{ $order->phone }}</div>
                <div class="detail-item"><strong>Shipping Address:</strong> {{ $order->address }}</div>
            </div>
            <div class="card">
                <h3>Order Summary</h3>
                <div class="detail-item"><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</div>
                <div class="detail-item"><strong>Status:</strong> <span style="text-transform: capitalize; font-weight: bold;">{{ $order->status }}</span></div>
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 15px;">
                    @csrf
                    @method('PATCH')
                    <label for="status" style="display: block; font-weight: bold; font-size: 14px; margin-bottom: 5px; color: #374151;">Change Status:</label>
                    <div style="display: flex; gap: 10px;">
                        <select name="status" id="status" style="padding: 8px; border-radius: 4px; border: 1px solid #ddd; flex-grow: 1;">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" style="background-color: #4f46e5; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">Update</button>
                    </div>
                    @error('status')
                    <p style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </form>
                <div class="detail-item"><strong>Total Amount:</strong> <strong style="font-size: 18px; color: #1f2937;">Rs. {{ number_format($order->total_amount, 2) }}</strong></div>
            </div>
        </div>

        <div class="card">
            <h3>Items Ordered</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                    <tr>
                        <td style="display: flex; align-items: center;">
                            @if($item->product && $item->product->image_path)
                            <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" width="50" style="margin-right: 15px; border-radius: 4px;">
                            @endif
                            {{ $item->product->name ?? 'Product not found' }}
                        </td>
                        <td>{{ $item->product->sku ?? 'N/A' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rs. {{ number_format($item->price, 2) }}</td>
                        <td>Rs. {{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>