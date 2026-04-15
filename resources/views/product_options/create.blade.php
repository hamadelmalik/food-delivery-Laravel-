@extends('layouts.dashboard')

@section('title', 'Add Product Options')

@section('content')
<div class="container mx-auto p-4">


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

    <form action="{{ route('product-options.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <table class="min-w-full bg-white border rounded mb-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Type</th>
                    <th class="p-2 border">Name</th>
                    <th class="p-2 border">Price</th>
                    <th class="p-2 border">Image</th>
                    <th class="p-2 border">Action</th>
                </tr>
            </thead>
            <tbody id="options-container">
                <tr class="option-row">
                    <td class="p-2 border">
                        <select name="options[0][type_id]" class="border p-1 w-full" required>
                            <option value="">Select Type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ ucfirst($type->name) }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="p-2 border">
                        <input type="text" name="options[0][name]" class="border p-1 w-full" required>
                    </td>
                    <td class="p-2 border">
                        <input type="number" step="0.01" name="options[0][price]" class="border p-1 w-full">
                    </td>
                    <td class="p-2 border">
                        <input type="file" name="options[0][image]" class="border p-1 w-full">
                    </td>
                    <td class="p-2 border text-center">
                        <button type="button" class="remove-option bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">Remove</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="button" id="add-option" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mb-4">Add Another Option</button>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Save All Options</button>
    </form>
</div>

@foreach($types as $type)
    <h3 class="font-bold mt-4">
        {{ $type->name }}
    </h3>

    <div class="flex flex-wrap gap-2 ml-4">
        @foreach($type->productOptions as $option)
            <div class="border px-3 py-1 rounded">
                {{ $option->name }}
            </div>
        @endforeach
    </div>

@endforeach
<script>
let optionIndex = 1;

document.getElementById('add-option').addEventListener('click', function() {
    const container = document.getElementById('options-container');
    const firstRow = document.querySelector('.option-row');
    const newRow = firstRow.cloneNode(true);

    // Update input names
    newRow.querySelectorAll('input, select').forEach(input => {
        const oldName = input.getAttribute('name');
        const newName = oldName.replace(/\[\d+\]/, `[${optionIndex}]`);
        input.setAttribute('name', newName);

        // Reset values
        if(input.type === 'file') input.value = "";
        else input.value = "";
    });

    container.appendChild(newRow);
    optionIndex++;
});

// Remove row
document.addEventListener('click', function(e){
    if(e.target && e.target.classList.contains('remove-option')){
        const rows = document.querySelectorAll('.option-row');
        if(rows.length > 1){
            e.target.closest('.option-row').remove();
        } else {
            alert('At least one option is required.');
        }
    }
});
</script>
@endsection
