@include('layouts.navbar')
@extends('layouts.general')

@section('title', '{{$product->name}}?')

@section('content')
    
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-12" style="margin-bottom:15px;">
                <a href="{{route('shop.view',$product->shop_contents->getId())}}">Go back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-8 ">
                <div class="product_image_holder_page">
                    @if(is_null($product->product_image))
                        <img class="product_image" src="https://1145472098.rsc.cdn77.org/wp-content/uploads/2018/07/gray-banner-background-1900x900.jpg" alt="Default shop banner. Gray background">
                    @else
                        <img class="product_image" src="{{ asset('storage/product_images/'. $product->product_image) }}" alt="product image for {{$product->name}}">
                    @endif
                </div>
            </div>
            <div class="col sm-12 col-md-4">
                <h3>{{$product->name}}</h3>
                <h5>${{$product->price}}</h5>
                <p>{{$product->description}}</p>
                <div class=row>
                    <div class="col-6">
                        <form action="#" method="POST"> {{-- {{ route('cart.addToCart', $product->id) }} --}}
                            @csrf
                                <button type="submit" class="btn btn-outline-primary">
                                    Add to Cart
                                </button>
                        </form>
                    </div>
                    <div class="col-6">
                        <form action="{{ route('bookmark.addToBookmarks', $product->id) }}" method="POST"> 
                            @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                    </svg>
                                    Add to Bookmarks
                                </button>
                        </form>
                    </div>
                </div>
                @can('editProduct', [App\Models\User::class, $product])
                    <div class="row">
                        <div class="col-12">
                        <br>
                        <a class="btn btn-warning" href="{{ route('product.edit', $product->id) }}" role="button">Edit Product</a>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>

@endsection