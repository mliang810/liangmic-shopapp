<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>@yield('title')</title>
    {{-- <style>
        .form-group.required .form-label:after {
            content:"*";
            color:red;
        }
    </style> --}}
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="{{ route('home') }}">Shopapp</a>
        <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item">
                    <a class="nav-link" href="#">Browse Shops</a>
            </li>

            @can('makeShop', App\Models\User::class)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop.create') }}">Create Shop</a>
                </li>
            @endcan

            </ul>

            <ul class="navbar-nav ml-auto">
                @if (Auth::check())
                    @can('editShop', App\Models\User::class)
                        @php 
                            $user=Auth::user();
                        @endphp
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('shop.view', $user->shop->id) }}">My Shop</a>
                        </li>
                    @endcan
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#">Cart</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Bookmarks</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">My Account</a>
                    </li>
                    

                    <li class="nav-item">
                        <form method="post" action="{{ route('auth.logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                    <a class="nav-link" href="{{ route('registration.index') }}">Register</a>
                    </li>

                    <li class="nav-item">
                            <a class="nav-link" href="{{route('auth.index') }}">Login</a>
                    </li>
                @endif
            </ul>

            {{-- <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> --}}
        </div>
    </nav>
    <br>
    {{-- <div class="container">
        <div>
            <header>
                <h2>@yield('title')</h2>
            </header>
            <main>
                @yield('content')
            </main>
        </div>
    </div> --}}


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
