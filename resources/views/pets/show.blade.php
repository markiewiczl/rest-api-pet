@extends('layouts.app')

@section('content')
    <h1>{{ $pet['name'] }}</h1>
    <p>ID: {{ $pet['id'] }}</p>
    <p>Category: {{ $pet['category']['name'] }}</p>
    <p>Photo URLs: {{ implode(',', $pet['photoUrls']) }}</p>
    <p>Tags: {{ implode(',', array_column($pet['tags'], 'name')) }}</p>
    <p>Status: {{ $pet['status'] }}</p>
    <a href="{{ route('pets.edit', $pet['id']) }}">Edit</a>
@endsection
