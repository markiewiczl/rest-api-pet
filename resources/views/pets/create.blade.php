@extends('layouts.app')

@section('content')
    <h1>Add New Pet</h1>
    <form action="{{ route('pets.store') }}" method="POST">
        @csrf
        <label for="id">ID</label>
        <input type="text" name="id" id="id">

        <label for="category_id">Category ID</label>
        <input type="text" name="category_id" id="category_id">

        <label for="category_name">Category Name</label>
        <input type="text" name="category_name" id="category_name">

        <label for="name">Name</label>
        <input type="text" name="name" id="name">

        <label for="photoUrls">Photo URLs (comma-separated)</label>
        <input type="text" name="photoUrls" id="photoUrls">

        <label for="tags">Tags (comma-separated)</label>
        <input type="text" name="tags" id="tags">

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="available">Available</option>
                <option value="pending">Pending</option>
                <option value="sold">Sold</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Pet</button>
    </form>
@endsection
