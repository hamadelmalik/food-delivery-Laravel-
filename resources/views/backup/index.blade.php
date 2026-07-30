@extends('layouts.app')

@section('content')

<h2>Database Backup</h2>

<form action="{{ route('backup.create') }}" method="POST">
    @csrf

    <button type="submit">
        Create Backup
    </button>

</form>

@endsection
