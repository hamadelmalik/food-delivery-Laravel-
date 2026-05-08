<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

   @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md p-4">

        <h1 class="text-xl font-bold mb-6">
            Dashboard
        </h1>

        <nav class="flex flex-col gap-2">

    <a href="{{ route('categories.index') }}"
       class="p-2 rounded hover:bg-gray-200">
        📂 Categories
    </a>

    <a href="{{ route('products.create') }}"
       class="p-2 rounded hover:bg-gray-200">
        📦 Add Product
    </a>

    <a href="{{ route('option-types.index') }}"
       class="p-2 rounded hover:bg-gray-200">
        ⚙️ Option Types
    </a>

    <a href="{{ route('product-options.create') }}"
       class="p-2 rounded hover:bg-gray-200">
        ➕ Add Product Option
    </a>


</nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">

        @yield('content')

    </main>

</body>
</html>
