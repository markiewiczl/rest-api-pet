@extends('layouts.app')

@section('content')
    <h1>Edit Pet</h1>
    <form action="{{ route('pets.update', $pet['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="id">ID</label>
        <input type="text" name="id" id="id" value="{{ $pet['id'] }}" readonly>

        <label for="category_id">Category ID</label>
        <input type="text" name="category_id" id="category_id" value="{{ $pet['category']['id'] }}">

        <label for="category_name">Category Name</label>
        <input type="text" name="category_name" id="category_name" value="{{ $pet['category']['name'] }}">

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ $pet['name'] }}">

        <label for="photoUrls">Photo URLs (comma-separated)</label>
        <input type="text" name="photoUrls" id="photoUrls" value="{{ implode(',', $pet['photoUrls']) }}">

        <label for="tags">Tags (comma-separated)</label>
        <input type="text" name="tags" id="tags" value="{{ implode(',', array_column($pet['tags'], 'name')) }}">

        <label for="status">Status</label>
        <input type="text" name="status" id="status" value="{{ $pet['status'] }}">

        <button type="submit">Update Pet</button>
    </form>
@endsection
