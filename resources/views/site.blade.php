<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href=" {{ asset('/img/favicon.png') }} ">
    <link rel="stylesheet" href="{{ asset('css/animation.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href=" {{ asset('css/shards.min.css') }} ">
    <link rel="stylesheet" href=" {{ asset('css/shards-extras.min.css') }} ">
    <title>Document</title>
</head>
<body>
    

    <div id="app">
        <router-link :to="{name: 'home'}">
            <i class="fas fa-arrow-right"></i>
            Home
        </router-link>

        <transition name="slide-fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>



    <script src=" {{ asset('js/app.js') }} "></script>
    <script src=" {{ asset('js/shards.min.js') }} "></script>
</body>
</html>