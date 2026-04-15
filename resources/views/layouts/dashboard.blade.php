<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    @vite('resources/css/app.css') <!-- Make sure Tailwind is compiled -->
</head>
<body class="bg-gray-100 h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md p-4">
        <h1 class="text-xl font-bold mb-6">My Dashboard</h1>
        <nav class="flex flex-col gap-2">
            <a href="{{ route('categories.index') }}" class="p-2 rounded hover:bg-gray-200">Categories</a>
            <a href="{{ route('products.index') }}" class="p-2 rounded hover:bg-gray-200">Products</a>
            <a href="{{ route('product-options.create') }}" class="p-2 rounded hover:bg-gray-200">Add Product Option</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold mb-4">@yield('title', 'Dashboard')</h2>
        <div>
            @yield('content')
        </div>
    </main>

</body>
</html>
