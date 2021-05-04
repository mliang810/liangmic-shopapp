@include('layouts.navbar')
@extends('layouts.general')

@section('title', 'delete {{$shop->shopName}}?')

@section('content')
    <h1>Delete "{{$shop->shopName}}"?</h1>
    <div><strong>This change will be final. </strong></div>
    <form action="{{ route('shop.deleteFinal', $shop->id) }}" method="POST"> 
            @csrf
            <br><br>
            <button type="submit" class="btn btn-danger">
                    Confirm Deletion
            </button>
    </form>
@endsection