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
</head>
<body>
    

    <div id="app">
        <site-navbar></site-navbar>

        <div class="container-fluid mt-4 pl-4 pr-4">
            <transition name="slide-fade" mode="out-in">
                <router-view></router-view>
            </transition>
        </div>

        {{-- <site-footer></site-footer> --}}
    </div>



    <script src=" {{ asset('js/app.js') }} "></script>
    <script src=" {{ asset('js/shards.min.js') }} "></script>
</body>
</html>