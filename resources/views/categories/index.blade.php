@extends('layouts.app')

@section('title', 'Categories')

@section('content')

<div class="space-y-6">

    <!-- Add Form (Top) -->
    <div class="bg-white p-6 rounded-lg shadow">

        <h2 class="text-xl font-bold mb-4">Add Category</h2>

        <form action="{{ route('categories.store') }}" method="POST" class="flex gap-3">
            @csrf

            <input
                type="text"
                name="name"
                placeholder="Enter category name"
                required
                class="flex-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none"
            >

            <button
                type="submit"
                class="bg-blue-600 text-white px-6 rounded-lg hover:bg-blue-700"
            >
                Add
            </button>
        </form>

    </div>

    <!-- List (Bottom) -->
    <div class="bg-white p-6 rounded-lg shadow">

        <h2 class="text-xl font-bold mb-4">Categories List</h2>

        @if(session('success'))
            <div class="mb-3 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border">
           <thead class="bg-gray-100">
    <tr>
        <th class="p-2 text-left">ID</th>
        <th class="p-2 text-left">Name</th>
       <th class="p-2 text-right">Actions</th>
    </tr>
</thead>

          <tbody>
@foreach($categories as $category)
    <tr class="border-t hover:bg-gray-50">

        <td class="p-2">{{ $category->id }}</td>
        <td class="p-2">{{ $category->name }}</td>

      <td class="p-2 text-right">
    <div class="flex justify-end gap-2">

        <!-- Edit -->
        <button
            class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600 transition">
            Edit
        </button>

        <!-- Delete -->
        <button
            class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition">
            Delete
        </button>

    </div>
</td>
    </tr>
@endforeach
</tbody>
        </table>

    </div>

</div>

@endsection
