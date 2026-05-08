<ul class="p-4 space-y-2">

    <li>
        <a href="{{ route('dashboard') }}"
           class="{{ request()->routeIs('dashboard') ? 'bg-blue-600 p-2 block rounded' : 'block p-2 hover:bg-gray-700' }}">
            Dashboard
        </a>
    </li>

    <li>
        <a href="{{ route('products.index') }}"
           class="{{ request()->routeIs('products.*') ? 'bg-blue-600 p-2 block rounded' : 'block p-2 hover:bg-gray-700' }}">
            Products
        </a>
    </li>

    <li>
        <a href="{{ route('products.create') }}"
           class="{{ request()->routeIs('products.create') ? 'bg-blue-600 p-2 block rounded' : 'block p-2 hover:bg-gray-700' }}">
            Add Product
        </a>
    </li>

</ul>
