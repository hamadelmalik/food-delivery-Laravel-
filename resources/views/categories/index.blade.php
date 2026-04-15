<h1>Categories List</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<ul>
    @foreach($categories as $category)
        <li>{{ $category->name }}</li>
    @endforeach
</ul>

<a href="{{ route('categories.create') }}">Add New Category</a>
