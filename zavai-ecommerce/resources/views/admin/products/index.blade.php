<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Products - Zavai Admin</title>
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
        {{-- Success Message --}}
        @if (session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
        @endif

        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Manage Products</h1>
            <a href="{{ route('admin.products.create') }}" class="button">Add New Product</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>Rs. {{ number_format($product->price, 2) }}</td>
                    <td>
                        <a href="#">Edit</a>
                        <a href="#">Delete</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>