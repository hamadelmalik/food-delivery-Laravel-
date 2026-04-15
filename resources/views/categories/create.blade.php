<h1>Add New Category</h1>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <label>Category Name:</label>
    <input type="text" name="name" required>
    <button type="submit">Save</button>
</form>
