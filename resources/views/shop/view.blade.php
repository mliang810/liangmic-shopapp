@include('layouts.navbar')
@extends('layouts.general')

@section('content')
    @if(is_null($shop->banner_image))
        <img id="banner" src="https://1145472098.rsc.cdn77.org/wp-content/uploads/2018/07/gray-banner-background-1900x900.jpg" alt="Default shop banner. Gray background">
    @else
        {{-- <img id="banner" src="{{$shop->banner_image}}" alt="Shop banner image for {{$shop->name}}"> --}}
    @endif
    {{-- / inline css if you use jumbotron --> style="background-image: url(http://i54.tinypic.com/4zuxif.jpg)" --}}

    <div class="container">
        <br>
        <h1 id="shopName">{{ $shop->shopName }}</h1>
        <div class="row">
            <div class="col-3">
                <h3>Categories</h3>
                <a href= {{route('shop.view', $shop->id) }}>All Products</a>
                <?php foreach($categories as $category) :  ?>
                    <a href= {{ route('shop.category', $shop->id, $category->id) }}>{{ $category->name }}</a>
                <?php endforeach; ?> 
            </div>
            <div class="col-9">
                {{-- <h2>All products</h2> #in categories page, you would write the name of the current category here --}}
                <?php foreach($products as $product) :  ?>
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <div>{{ $product->product_image }}</div>
                        {{-- </div><a href="{{ route('',$product->id) }}">{{ $product->name }}</a></div> --}} {{-- route linking to product page--}}
                            </div>${{ $product->price }}</div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
@endsection