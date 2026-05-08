@extends('layouts.app')

@section('title', 'Add Product Options')

@section('content')

<div class="container mx-auto p-4">

    <!-- Title -->
    <div class="mb-6">
        <h3 class="text-2xl font-bold">Add Product Options</h3>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if($errors->any())
        <div class="bg-red-200 text-red-800 p-3 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('product-options.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white shadow rounded-lg overflow-hidden">

            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 border text-left">Type</th>
                        <th class="p-3 border text-left">Name</th>
                        <th class="p-3 border text-left">Price</th>
                        <th class="p-3 border text-left">Image</th>
                        <th class="p-3 border text-center">Action</th>
                    </tr>
                </thead>

                <tbody id="options-container">

                    <tr class="option-row">

                        <!-- Type -->
                        <td class="p-2 border">
                            <select
                                name="options[0][type_id]"
                                class="border p-2 w-full rounded"
                                required
                            >
                                <option value="">Select Type</option>

                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">
                                        {{ ucfirst($type->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <!-- Name -->
                        <td class="p-2 border">
                            <input
                                type="text"
                                name="options[0][name]"
                                class="border p-2 w-full rounded"
                                placeholder="Option Name"
                                required
                            >
                        </td>

                        <!-- Price -->
                        <td class="p-2 border">
                            <input
                                type="number"
                                step="0.01"
                                name="options[0][price]"
                                class="border p-2 w-full rounded"
                                placeholder="0.00"
                            >
                        </td>

                        <!-- Image -->
                        <td class="p-2 border">
                            <input
                                type="file"
                                name="options[0][image]"
                                class="border p-2 w-full rounded"
                            >
                        </td>

                        <!-- Remove -->
                        <td class="p-2 border text-center">
                            <button
                                type="button"
                                class="remove-option bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded"
                            >
                                Remove
                            </button>
                        </td>

                    </tr>

                </tbody>
            </table>

        </div>

        <!-- Buttons -->
        <div class="flex gap-3 mt-4">

            <button
                type="button"
                id="add-option"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded"
            >
                Add Another Option
            </button>

            <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
            >
                Save All Options
            </button>

        </div>

    </form>

</div>

<!-- JavaScript -->
<script>

    let optionIndex = 1;

    // Add new row
    document.getElementById('add-option').addEventListener('click', function () {

        const container = document.getElementById('options-container');

        const firstRow = document.querySelector('.option-row');

        const newRow = firstRow.cloneNode(true);

        // Update input names
        newRow.querySelectorAll('input, select').forEach(input => {

            const oldName = input.getAttribute('name');

            const newName = oldName.replace(/\[\d+\]/, `[${optionIndex}]`);

            input.setAttribute('name', newName);

            // Reset values
            if (input.type === 'file') {

                input.value = '';

            } else if (input.tagName === 'SELECT') {

                input.selectedIndex = 0;

            } else {

                input.value = '';

            }

        });

        container.appendChild(newRow);

        optionIndex++;

    });

    // Remove row
    document.addEventListener('click', function (e) {

        if (e.target && e.target.classList.contains('remove-option')) {

            const rows = document.querySelectorAll('.option-row');

            if (rows.length > 1) {

                e.target.closest('.option-row').remove();

            } else {

                alert('At least one option is required.');

            }

        }

    });

</script>

@endsection
