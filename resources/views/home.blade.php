@include('layouts.navbar')
@extends('layouts.general')

@section('title','Home Page')

@section('content')
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ session('success') }}
    </div>
    @endif

    
    <div class="container">
        <p>Welcome</p>
    </div>
@endsection