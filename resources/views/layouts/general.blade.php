<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>@yield('title')</title>
    <style>
        .form-group.required .form-label:after {
            content:"*";
            color:red;
        }
        .banner-holder{
            width:100%;
            max-height:350px;
            overflow:hidden;
            text-align: center;
            margin:0;
            padding:0;
            margin-bottom: 10px;
        }
        .banner{
            width:100%;
            /* max-height:350px; */
            margin:0;
            padding:0;
        }

        #shopName{
           text-align: center;
           margin-bottom:5%;
        }

        .product_image{
            width:100%
        }
        
        .product_image #bookmarkimg{
            width:100%;
        }

        .product_image_holder{
            width:100%;
            height:width;
            max-width:200px;
            overflow:hidden;
            
        }
        .product_image_holder_page{
            width:100%;
            /* max-width: 350px; */
            overflow:hidden;
        }
    </style>
</head>
<body>
    <div class="container">
        <div>
            <main>
                @yield('content')
            </main>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
