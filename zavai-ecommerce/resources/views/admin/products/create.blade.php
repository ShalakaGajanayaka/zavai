<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add New Product - Zavai Admin</title>
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
        }

        .content {
            padding: 40px;
        }

        h1,
        h2 {
            color: #1f2937;
        }

        .form-card {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #374151;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 100px;
        }

        .button {
            background-color: #4f46e5;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        .error {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2><a href="{{ route('admin.dashboard') }}" style="text-decoration: none; color: inherit;">Zavai Admin Panel</a></h2>
    </div>

    <div class="content">
        <h1>Add New Product</h1>

        <div class="form-card">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="input-group">
                    <label for="name">Product Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required>
                    @error('name') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="input-group">
                    <label for="sku">SKU (Stock Keeping Unit)</label>
                    <input id="sku" type="text" name="sku" value="{{ old('sku') }}" required>
                    @error('sku') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="input-group">
                    <label for="price">Price (Rs.)</label>
                    <input id="price" type="text" name="price" value="{{ old('price') }}" required>
                    @error('price') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="input-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description">{{ old('description') }}</textarea>
                    @error('description') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="input-group">
                    <label for="image">Product Image</label>
                    <input id="image" type="file" name="image">
                    @error('image') <div class="error">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="button">Save Product</button>
            </form>
        </div>
    </div>
</body>

</html>