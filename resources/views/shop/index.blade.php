@include('layouts.navbar')
@extends('layouts.general')

@section('title','Store Directory')
@section('content')
    <table class="table ">
            <thead>
                <th>Shop Name</th>
                <th>Owner</th> {{-- their user name goes here --}}
                <th>Description</th>
            </thead>
            <tbody>
                <?php foreach ($shops as $shop) : ?>
                    <tr>
                        <td>
                            <a href="{{route('shop.view', $shop->id)}}">{{ $shop->shopName }}</a>
                        </td>
                        <td>
                            {{ $shop->user->username }}
                        </td>
                        <td>
                            @if(!empty($shop->shopDescription) && isSet($shop->shopDescription))
                                {{ $shop->shopDescription }}
                            @else
                                <span style="opacity:0.5;">No description was provided</span>
                            @endif
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
@endsection