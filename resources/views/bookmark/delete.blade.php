@include('layouts.navbar')
@extends('layouts.general')

@section('title', 'Delete'')

@section('content')
    <h1>Delete your bookmark for "{{$bookmark->product->name}}"?</h1>
    <form action="{{ route('bookmark.deleteFinal', $bookmark->id) }}" method="POST"> 
            @csrf
            <br><br>
            <button type="submit" class="btn btn-danger">
                    Confirm Deletion
            </button>
    </form>
@endsection