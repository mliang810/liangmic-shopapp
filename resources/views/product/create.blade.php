@include('layouts.navbar')
@extends('layouts.general')

@section('title', 'Create My Shop')

@section('content')
    <h1>Create a Product Listing</h1>
    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" value = "{{ old('name')}}" placeholder="Product Name">
            @error('name') 
                <small class="text-danger">{{ $message }} </small>
            @enderror
        </div>        
        <div class="form-group">
            <label for="price" class="form-label">Price $</label>
            <input type="number" step="0.01" name="price" id="price" placeholder="0.00" value="{{ old('price')}}">
            @error('price') 
                    <small class="text-danger">{{ $message }} </small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Product Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Product Description Here">{{ old('description')}}</textarea>
            @error('description') 
                <small class="text-danger">{{ $message }} </small>
            @enderror
        </div>

        <div class="form-group">
            <label for="product_photo">Upload Product Image</label>
            <input type="file" class="form-control-file" name="product_photo" accept=".jpg, .jpeg, .png, .svg, .gif" id="product_photo">
            @error('product_photo') 
                <small class="text-danger">{{ $message }} </small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Product Category</label>
            <input type="text" name="category" id="category" class="form-control" placeholder="Input Product Category" value = "{{ old('category')}}">
            @error('category') 
                <small class="text-danger">{{ $message }} </small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tags" class="form-label">Tags (seperate using commas)</label>
            <textarea class="form-control" id="tags" name="tags" rows="3" placeholder="Input product tags here. Seperate different tags using commas.">{{ old('tags')}}</textarea>
            @error('tags') 
                <small class="text-danger">{{ $message }} </small>
            @enderror
        </div>                

        <button type="submit" class="btn btn-primary">
            Save
        </button>
        {{-- @php(dd(App\Models\User::where('id', '=', Auth::user()->id)->first())) --}}
    </form>
@endsection