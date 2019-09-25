<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Sample App') - Laravel 入门教程</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="{{asset('../resources/assets/sass/app.scss')}}">
</head>
<body>
<header class="navbar navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="col-md-offset-1 col-md-10">
            @include('shared.messages')
            <a href="{{ route('home') }}" id="logo">Sample App</a>
            <nav>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ route('help') }}">帮助</a></li>
                    <li><a href="#">登录</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<div class="container">
    @yield('content')

</div>
</body>
</html>