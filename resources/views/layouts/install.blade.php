<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} 安装向导</title>

    @yield('head')
</head>
<body>
    @yield('content')

    @yield('script')
</body>
</html>
