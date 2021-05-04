@include('layouts.navbar')
@extends('layouts.general')

@section('title','Home Page')

@section('content')
    <div class="siteBanner">
        <img  src="{{ asset('storage/images/about_top.JPG') }}" alt="site banner image">
    </div>
    <div class="container">
        <h1>About Shopapp</h1>
        <h3>Our Mission</h3>
        <p style="font-size: 20px">
            Our aim is to make shopping for the average small business owner easier. Create your store using ShopApp. You can include products with affiliate links,
            so that you have everything in one place -- or sell your self made handicrafts here!
        </p>
        <br>
        <h3>What is this for?</h3>
        <p style="font-size: 20px">
            This was made for the ITP 405 final
        </p>
    </div>
@endsection