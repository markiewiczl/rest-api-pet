@extends('layouts.app')

@section('content')
    <h1>Pets</h1>
    <a href="{{ route('pets.create') }}">Add New Pet</a>

    <form method="GET" action="{{ route('pets.index') }}">
        <label for="status">Filter by status:</label>
        <select name="status" id="status" onchange="this.form.submit()">
            <option value="available" {{ $status == 'available' ? 'selected' : '' }}>Available</option>
            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="sold" {{ $status == 'sold' ? 'selected' : '' }}>Sold</option>
        </select>
    </form>

    <ul>
        @foreach ($pets as $pet)
            <li>
                <a href="{{ route('pets.show', $pet->id) }}">{{ $pet->name }}</a>
                <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
