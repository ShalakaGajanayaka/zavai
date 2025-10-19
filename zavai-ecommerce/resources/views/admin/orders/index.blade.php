<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Orders - Zavai Admin</title>
    {{-- Products index page එකේ තිබ්බ styles ටිකම මෙතනටත් දාන්න --}}
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
        }

        h1,
        h2 {
            color: #1f2937;
        }

        .button {
            background-color: #4f46e5;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        td a {
            background-color: #10b981;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2><a href="{{ route('admin.dashboard') }}" style="text-decoration: none; color: inherit;">Zavai Admin Panel</a></h2>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" style="background-color: #ef4444; color: white; border: none; padding: 10px 15px; border-radius: 6px; font-size: 14px; cursor: pointer;">Log Out</button>
        </form>
    </div>

    <div class="content">
        <h1>Manage Orders</h1>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Ordered At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>Rs. {{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>