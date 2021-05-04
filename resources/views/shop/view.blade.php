@include('layouts.navbar')
@extends('layouts.general')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('success') }}
        </div>
    @endif
    @can('editMyShop', [App\Models\User::class, $shop])
        {{-- @if($user->shop->id === $shop->id) --}}
        @cannot('editOn', App\Models\User::class) {{-- editing is currently off. button to turn ON is available --}}
            <form action="{{ route('shop.editOn', $shop->id) }}" method="POST"> 
                @csrf
                <button type="submit" class="btn btn-primary">Edit Shop</button>  
            </form>
        @endcan
        @can('editOn', App\Models\User::class) {{-- editing is currently on. button to turn OFF is available --}}
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Warning! </strong>Toggling edit view off does <strong>not</strong> save your changes to banner image/shop title. 
                To see your changes, refresh the page.
            </div>
            <div class="row">
                <div class="col-4">
                    <form action="{{ route('shop.editOff', $shop->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Toggle Edit View Off</button>
                    </form>
                </div>
                <div class="col-4">
                    <a class="btn btn-primary" href="{{route('product.create')}}" target="_blank" role="button">Create new product</a>
                </div>
                <div class="col-4">
                    <a class="btn btn-outline-danger" href="{{route('shop.delete', $shop->id)}}" role="button">Delete Store</a>
                </div>
            </div>
        @endcan
        {{-- @endif --}}
    @endcan
    <br>

{{-- -------------------------------------- --}}

    @if(is_null($shop->banner_image))
    <div class="banner-holder">
        <img class="banner" src="https://1145472098.rsc.cdn77.org/wp-content/uploads/2018/07/gray-banner-background-1900x900.jpg" alt="Default shop banner. Gray background">
    </div>
    @else
    <div class="banner-holder">
        <img class="banner" src="{{ asset('storage/shop_banners/'. $shop->banner_image) }}" alt="Shop banner image for {{$shop->shopName}}">
    </div>
        {{-- <img src="{{ asset("storage/shop_banners/$shop->banner_image") }}" alt="Shop banner image for {{$shop->shopName}}"/> --}}

    @endif
    {{-- / inline css if you use jumbotron --> style="background-image: url(http://i54.tinypic.com/4zuxif.jpg)" --}}

    @can('editOn', App\Models\User::class) {{-- if editing is on, they will see the version with the buttons --}}
    <form action="{{ route('shop.update', $shop->id) }}" method="POST" enctype="multipart/form-data"> 
        @csrf
        <div class="row">
            <div class="col-9">
                <div class="form-group row">
                    <label class="col-sm-2 form-label" for="banner_image"><strong>Upload New Banner</strong></label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control-file" name="banner_image" id="banner_image" accept=".jpg, .jpeg, .png, .svg, .gif">
                    </div>
                    @error('banner_image') 
                        <small class="text-danger">{{ $message }} </small>
                    @enderror
                </div>
            </div>
            <div class="col-3">
                <button type="submit" class="btn btn-outline-primary">
                    Save Changes
                </button>
            </div>
        </div>
        

        <div class="container">
            <br>
            <div class="form-group row">
                <label for="shopName" class="form-label col-sm-2"><strong>Shop Title</strong></label>
                <div class="col-sm-10">
                    <input type="text" name="shopName" class="form-control" value = "{{ old('shopName', $shop->shopName)}}" placeholder="New Shop Name">
                </div>
            </div>
            <div class="form-group row">
                <label for="shopDescription" class="form-label col-sm-2"><strong>Shop Description</strong></label>
                <div class="col-sm-10">
                    <input type="text" name="shopDescription" class="form-control" value = "{{ old('shopDescription', $shop->shopDescription)}}" placeholder="Change Shop Description">
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <h3>Categories</h3>
                    <ul style="list-style-type:none; padding:0; margin:0">
                        <li><a href= {{route('shop.view', $shop->id) }}>All Products</a></li>
                        <?php foreach($categories as $category) :  ?>
                            <li><a href="{{route('shop.category', [$shop->id,$category->id])}}">{{  $category->name }}</a></li>
                        <?php endforeach; ?> 
                    </ul>
                </div>
                <div class="col-9">
                    {{-- <h2>All products</h2> #in categories page, you would write the name of the current category here --}}
                        <div class="row">
                            @if(count($products) ===0)
                                <div class="row">
                                    <h2 style="opacity: 0.5;">No Products</h2>
                                </div>
                            @endif

                            <?php foreach($products as $product) :  ?>
                                <div class="col-sm-12 col-md-4 col-lg-3 product-holder">
                                    @if(is_null($product->product_image))
                                        <div><img class="product_image" src="https://1145472098.rsc.cdn77.org/wp-content/uploads/2018/07/gray-banner-background-1900x900.jpg" alt="default. no image provided. "></div>
                                    @else
                                        <div class="product_image_holder">
                                            <img class="product_image" src="{{ asset('storage/product_images/'. $product->product_image) }}" alt="product image for {{$product->name}}">
                                        </div>
                                    @endif
                                {{-- <div><a href="{{ route('',$product->id) }}">{{ $product->name }}</a></div> --}} {{-- route linking to product page--}}
                                <div><a href="{{route('product.view', $product->id)}}">{{ $product->name }}</a></div>
                                    <div>${{ $product->price }}</div>
                                    <a class="btn btn-outline-danger" href="{{route('product.delete', $product->id)}}" role="button">Delete</a>
                                </div> 
                            <?php endforeach; ?>
                        </div>
                    
                </div>
            </div>
        </div>       
    </form> 


    @else
    <div class="container">
        <br>
        <h1 id="shopName">{{ $shop->shopName }}</h1>
        <div class="row">
            <div class="col-3">
                <h3>Categories</h3>
                <ul style="list-style-type:none; padding:0; margin:0">
                    <li><a href= {{route('shop.view', $shop->id) }}>All Products</a></li>
                    <?php foreach($categories as $category) :  ?>
                        {{-- <a href = {{ route('shop.category', ['id' => ($shop->id), 'category_id' => ($category->id)]) }}> {{ $category->name }} </a> --}}
                        {{-- <li><a href = "'/shop/'. {{$shop->id}}.'/'.{{ $category->id }}"> {{ $category->name }}"></a></li> --}}
                        {{-- <li><a href="{{ $shop->id }}/{{ $category->id }}">{{ $category->name }}</a></li> --}}
                        <li><a href="{{route('shop.category', [$shop->id,$category->id])}}">{{  $category->name }}</a></li>
                    <?php endforeach; ?> 

                </ul>
            </div>
            <div class="col-9">
                {{-- <h2>All products</h2> #in categories page, you would write the name of the current category here --}}
                    <div class="row">
                        @if(count($products) ===0)
                            <div class="row">
                                <h2 style="opacity: 0.5;">No Products</h2>
                            </div>
                        @endif

                        <?php foreach($products as $product) :  ?>
                        <div class="col-sm-12 col-md-4 col-lg-3 product-holder">
                            @if(is_null($product->product_image))
                                <div><img class="product_image" src="https://1145472098.rsc.cdn77.org/wp-content/uploads/2018/07/gray-banner-background-1900x900.jpg" alt="Default product. Gray background -- no image was provided"></div>
                            @else
                                <div class="product_image_holder"><img class="product_image" src="{{ asset('storage/product_images/'. $product->product_image) }}" alt="product image for {{$product->name}}"></div>
                            @endif
                            <div><a href="{{route('product.view', $product->id)}}">{{ $product->name }}</a></div>
                            <div>${{ $product->price }}</div>
                        </div> 
                        <?php endforeach; ?>
                    </div>
                
            </div>
        </div>
    </div>
    @endcan
@endsection