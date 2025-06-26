<!DOCTYPE html>
<html lang="en" data-theme="default">
@include('layouts.includes.head')

<body class="home-page">
    @include('layouts.includes.header')

    <div class="main-body-wrapper">
        @yield('content')
    </div>

    @include('layouts.includes.footer')
    <div class="offcanvas-overaly"></div>
    @include('layouts.includes.scripts')
</body>
