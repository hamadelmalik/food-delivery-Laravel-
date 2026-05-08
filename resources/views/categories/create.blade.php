@extends('layouts.app')

@section('title', 'Add Category')

@section('content')

<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">

    <h1 class="text-2xl font-bold mb-6 text-gray-800">
        Add New Category
    </h1>

    <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">
                Category Name
            </label>

            <input
                type="text"
                name="name"
                required
                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        <!-- Button -->
        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
        >
            Save Category
        </button>

    </form>

</div>

@endsection
