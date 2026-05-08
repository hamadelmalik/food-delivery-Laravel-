@extends('layouts.app')

@section('title', 'Add Products')

@section('content')

<div class="container mx-auto p-6 max-w-2xl">

    <h1 class="text-3xl font-bold mb-6">Add New Product</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white shadow-md rounded-lg p-6 space-y-4">

        @csrf

        <!-- Product Name -->
        <div>
            <label class="block font-semibold mb-1">Product Name</label>
            <input type="text" name="name" required
                   class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Description -->
        <div>
            <label class="block font-semibold mb-1">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
        </div>

        <!-- Price -->
        <div>
            <label class="block font-semibold mb-1">Price</label>
            <input type="number" step="0.01" name="price" required
                   class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Category -->
        <div>
            <label class="block font-semibold mb-1">Category</label>
            <select name="category_id" required
                    class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Image -->
        <div>
            <label class="block font-semibold mb-1">Product Image</label>
            <input type="file" name="image"
                   class="w-full border rounded p-2 bg-white">
        </div>

        <!-- Button -->
        <div class="pt-2">
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                Save Product
            </button>
        </div>

    </form>

</div>

@endsection
