@include('layouts.navbar')
@extends('layouts.general')

@section('title','{{Auth::user()->name}} Bookmarks')
@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <table class="table">
            <thead>
                <th>Product Name</th>
                <th>Shop Owner</th> {{-- their user name goes here --}}
                <th>Shop Name</th>
                <th>Description</th>
                <th>Date Added</th>
                <th></th>
            </thead>
            <tbody>
                <?php foreach ($bookmarks as $bookmark) : ?>
                    <tr>
                        <td>
                            <a href="{{route('product.view', $bookmark->product->id)}}">{{$bookmark->product->name}}</a>
                        </td>
                        <td>
                            {{$bookmark->product->user->username}}
                        </td>
                        <td>
                            @php
                                $shop = $bookmark->product->user->shop;
                            @endphp
                            <a href="{{route('shop.view', $shop->id)}}">{{ $shop->shopName }}</a>
                        </td>
                        <td>
                            @if(empty($bookmark->product->description) && !isSet($bookmark->product->description))
                                <span style="opacity:0.5;">No description was provided</span>
                            @else
                                {{ $bookmark->product->description }}
                            @endif
                        </td>
                        <td>
                            {{$bookmark->created_at}}
                        </td>
                        <td>
                            <a class="btn btn-outline-danger" href="{{route('bookmark.delete', $bookmark->id)}}" role="button">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
@endsection