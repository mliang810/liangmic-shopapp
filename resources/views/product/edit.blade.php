@include('layouts.navbar')
@extends('layouts.general')

@section('title')
    Editing {{ $product->name }}
@endsection

@section('content')
    <a class="btn btn-outline-danger" href="{{route('product.delete', $product->id)}}" role="button">Delete</a>
    <form action="{{ route('product.update', $product->id) }}" method="POST">
        @csrf
        <div class="form-group row">
            <label class="col-sm-2 form-label" for="product_photo"><strong>Upload New Product Photo</strong></label>
            <div class="col-sm-10">
                <input type="file" class="form-control-file" name="product_photo" id="product_photo" accept=".jpg, .jpeg, .png, .svg, .gif">
            </div>
            @error('banner_image') 
                <small class="text-danger">{{ $message }} </small>
            @enderror
        </div>

        <div class="form-group row">
            <label for="name" class="form-label col-sm-2">Product Name</label>
            <div class="col-sm-10">
                <input type="text" name="name" id="name" class="form-control" value = "{{ old('name', $product->name)}}" placeholder="Product Name">
            </div>
            @error('name') 
                <small class="text-danger">{{ $message }} </small>
            @enderror
        </div>

        <div class="form-group">
            <label for="price" class="form-label col-sm-2">Price $</label>
            <div class="col-sm-10">
                <input type="number" step="0.01" name="price" id="price" placeholder="0.00" value="{{ old('price', $product->price)}}">
            </div>
            @error('price') 
                    <small class="text-danger">{{ $message}} </small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Product Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Product Description Here">{{ old('description', $product->description)}}</textarea>
            @error('description') 
                <small class="text-danger">{{ $message }} </small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Product Category</label>
            <input type="text" name="category" id="category" class="form-control" placeholder="Input Product Category" value = "{{ old('category', $product->category->name)}}">
            @error('category') 
                <small class="text-danger">{{ $message }} </small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tags" class="form-label">Tags (seperate using commas)</label>
            <textarea class="form-control" id="tags" rows="3" name="tags" placeholder="Input product tags here. Seperate different tags using commas.">{{ old('tags', $product->tagStr)}}</textarea>
            @error('tags') 
                <small class="text-danger">{{ $message }} </small>
            @enderror
        </div>      

        <button type="submit" class="btn btn-primary">
            Save
        </button>
    </form>
@endsection