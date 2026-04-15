<h1>products List</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<ul>
    @foreach($products as $product)
        <li>{{ $product->name }}</li>
    @endforeach
</ul>

<a href="{{ route('products.create') }}">Add New Category</a>
