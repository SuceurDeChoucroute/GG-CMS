<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href=" {{ asset('/img/favicon.png') }} ">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="{{ asset('css/animation.css') }}">
        <link rel="stylesheet" href=" {{ asset('css/site.css') }} ">
    <title> {{ config('app.name') }} </title>

    @if (config('app.env') == "production")
        <!-- Global Site Tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-91334247-1 "></script>
        <script>
            window.dataLayer = window.dataLayer || [];
                    function gtag(){dataLayer.push(arguments);}
                    gtag('js', new Date());
                    gtag('config', ' UA-91334247-1 ');
        </script>
    @endif
</head>
<body>
    

    <div id="app">
        <site-navbar></site-navbar>

        <div class="container-fluid mt-4 pl-4 pr-4">
            <transition name="slide-fade" mode="out-in">
                <router-view></router-view>
            </transition>

            
            <site-partners v-show="$route.name != 'home'"></site-partners>
        </div>

        {{-- <site-footer></site-footer> --}}
    </div>



    <script src=" {{ asset('js/app.js') }} "></script>
    <script src=" {{ asset('js/shards.min.js') }} "></script>
    <script src="https://js.stripe.com/v3"></script>
</body>
</html>