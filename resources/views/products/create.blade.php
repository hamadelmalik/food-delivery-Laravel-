<h1>Add New Product</h1>

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Product Name:</label>
    <input type="text" name="name" required><br><br>

    <label>Description:</label>
    <textarea name="description"></textarea><br><br>

    <label>Price:</label>
    <input type="number" step="0.01" name="price" required><br><br>

    <label>Category:</label>
    <select name="category_id" required>
        <option value="">Select Category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select><br><br>

    <label>Product Image:</label>
    <input type="file" name="image"><br><br>

    <button type="submit">Save</button>
    @if(session('success'))
    <div style="color:green; font-weight:bold;">
        {{ session('success') }}
    </div>
@endif
</form>
