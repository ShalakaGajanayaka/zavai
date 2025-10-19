<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Zavai Admin Dashboard</title>
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

        .logout-button {
            background-color: #ef4444;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
        }

        .logout-button:hover {
            background-color: #dc2626;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Zavai Admin Panel</h2>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-button">Log Out</button>
        </form>
    </div>

    <div class="content">
        <h1>Welcome to the Zavai Admin Dashboard!</h1>
        <p>You have successfully logged in.</p>

        <p>
            <a href="{{ route('admin.products.index') }}" style="background-color: #10b981; color: white; padding: 10px 15px; text-decoration: none; border-radius: 6px; display: inline-block; margin-top: 20px;">
                Manage Products
            </a>
        </p>
        <p>
            <a href="{{ route('admin.users.index') }}" style="background-color: #f59e0b; color: white; padding: 10px 15px; text-decoration: none; border-radius: 6px; display: inline-block; margin-top: 10px;">
                Manage Users & Staff
            </a>
        </p>
        <p>
            <a href="{{ route('admin.orders.index') }}" style="background-color: #3b82f6; color: white; padding: 10px 15px; text-decoration: none; border-radius: 6px; display: inline-block; margin-top: 10px;">
                Manage Orders
            </a>
        </p>
    </div>
</body>

</html>