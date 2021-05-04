@include('layouts.navbar')
@extends('layouts.general')

@section('title', 'Delete product?')

@section('content')
    <h1>Delete "{{$product->name}}"?</h1>
    <form action="{{ route('product.deleteFinal', $product->id) }}" method="POST"> 
            @csrf
            <br><br>
            <button type="submit" class="btn btn-danger">
                    Confirm Deletion
            </button>
    </form>
@endsection