@include('layouts.navbar')
@extends('layouts.general')

@section('title', 'Profile')

@section('content')
    <p>Hello, {{ $user->name }}. Your email is {{ $user->email }}.</p>
@endsection