<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ config('app.name') }} </title>
    @include('admin.css')
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper" id="app">
        <admin-header app_name="{{ config('app.name') }}" app_name_mini="{{ config('app.name') }}"></admin-header>
        <admin-sidebar></admin-sidebar>

        <div class="content-wrapper">
    
        </div>

        <admin-footer version="1.0"></admin-footer>
    </div>
    


    @include('admin.script')
    <script src=" {{ asset('js/admin.js') }} "></script>
</body>

</html>