@extends('layouts.dashboard')

@section('title', 'Option Types')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Option Types</h2>

    <a href="{{ route('option-types.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">
        Add New Type
    </a>

    <table class="min-w-full bg-white border rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Name</th>
                <th class="p-2 border">Created At</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($types as $type)
            <tr>
                <td class="p-2 border">{{ $type->id }}</td>
                <td class="p-2 border">{{ ucfirst($type->name) }}</td>
                <td class="p-2 border">{{ $type->created_at->format('Y-m-d') }}</td>
                <td class="p-2 border flex gap-2">
                    <a href="{{ route('option-types.edit', $type->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded">Edit</a>
                    <form action="{{ route('option-types.destroy', $type->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
