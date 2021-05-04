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
        <h1 style="text-align: center; font-size:60px;">Welcome to Shopapp</h1>
        <div class="siteBanner">
            <img  src="{{ asset('storage/images/home_top.JPG') }}" alt="site banner image">
        </div>
        <h2>Make your <a href="{{route('shop.create')}}">own</a> store for free!</h2>
        <p>
            Using our platform, you can add your own products and tags to <a href="{{route('shop.create')}}">your store</a>. 
            What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum has been the industry's 
            standard dummy text ever since the 1500s when an unknown printer took a galley of type and scrambled it to make a type specimen book it has?
        </p>
        <div class="siteBanner">
            <img  src="{{ asset('storage/images/home_thir.JPG') }}" alt="site banner image">
        </div>
        <h2>Browse <a href="{{route('shop.index')}}">other</a> users' stores</h2>
        <p>
            Check out everyone else's <a href="{{route('shop.index')}}">stores</a> as well! 
            What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum has been the industry's 
            standard dummy text ever since the 1500s when an unknown printer took a galley of type and scrambled it to make a type specimen book it has?
        </p>
    </div>
@endsection