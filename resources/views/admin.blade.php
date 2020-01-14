<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href=" {{ asset('/img/favicon.png') }} ">

    <title> {{ config('app.name') }} - Admin </title>
    @include('admin.css')
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper" id="app">
        {{-- Header --}}
        <admin-header app_name="{{ config('app.name') }}" app_name_mini="{{ config('app.name') }}"></admin-header>
        
        {{-- Sidebar --}}
        <admin-sidebar></admin-sidebar>

        {{-- Content --}}
        <div class="content-wrapper">
            <transition name="slide-fade" mode="out-in">
                <router-view></router-view>
            </transition>
        </div>

        {{-- Footer --}}
        <admin-footer version="1.0"></admin-footer>
    </div>
    
    @include('admin.script')
    <script src=" {{ asset('js/admin.js') }} "></script>
</body>

</html>