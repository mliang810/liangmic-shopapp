@include('layouts.navbar')
@extends('layouts.general')

@section('title', 'Create My Shop')

@section('content')
    <form action="{{ route('shop.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Shop Name</label>
            <input type="text" name="title" id="title" class="form-control" value = "{{ old('title')}}">
            @error('title') 
                <small class="text-danger">{{ $message }} </small>
            @enderror
        </div>

        <div class="form-group">
            <label for="banner">Upload Shop Banner Photo</label>
            <input type="file" class="form-control-file" name="banner" id="banner">
            @error('banner') 
                <small class="text-danger">{{ $message }} </small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            Save
        </button>
        {{-- @php(dd(App\Models\User::where('id', '=', Auth::user()->id)->first())) --}}
    </form>
@endsection