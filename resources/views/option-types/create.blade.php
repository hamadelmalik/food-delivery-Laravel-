@extends('layouts.dashboard')

@section('title', 'Add Option Type')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Add Option Type</h2>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-200 text-red-800 p-2 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('option-types.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block font-bold mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="border p-2 w-full rounded" required>
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            Save Option Type
        </button>
        <a href="{{ route('option-types.index') }}" class="ml-2 bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded">
            Cancel
        </a>
    </form>
</div>
@endsection
