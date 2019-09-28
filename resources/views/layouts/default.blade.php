<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Sample App') - Laravel 入门教程</title>
    <link rel="stylesheet" href="/css/app.css">
    {{--<link rel="stylesheet" href="{{asset('../resources/assets/sass/app.scss')}}">--}}
</head>
<body>
@include('layouts.header')

<div class="container">
    <div class="col-md-offset-1 col-md-10">
        @include('shared.messages')
        @yield('content')
        {{--@include('layouts.footer')--}}
    </div>

</div>
@include('shared.messages')
<script src="/js/app.js"></script>
</body>
</html>