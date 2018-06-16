<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} - @yield('title')</title>
    @include('admin.shared.head')
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">

            <!-- sidebar menu -->
    @include('admin.shared.sidebar')
            <!-- /sidebar menu -->

            <!-- top navigation -->
    @include('admin.shared.header')
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                @yield('content')
            </div>
            <!-- /page content -->

            <!-- footer content -->
    @include('admin.shared.footer')
            <!-- /footer content -->
        </div>
    </div>
    @include('admin.shared.scripts')
    <!-- Functions for content -->
    @stack('functions')
</body>
</html>