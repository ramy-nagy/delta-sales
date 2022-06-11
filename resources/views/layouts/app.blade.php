<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="dashboard">
    <meta name="author" content="Ramy Nagy">
    <title>{{ config('app.name', '') }} - @yield('title')</title>

    @include('layouts.styles')
</head>
@php
    app()->getLocale() == 'ar' ? $dir = 'rtl' : $dir = 'ltr';
@endphp
<body dir="{{ $dir ?? '' }}" class="border-top-wide border-primary d-flex flex-column ">
    <div class="page">
        @include('layouts.top-navbar')
        @include('layouts.navbar')
        <div class="page-wrapper">
            <div class="container-xl">
                <!-- Page title -->
                <div class="page-header d-print-none">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <!-- Page pre-title -->
                            <div class="page-pretitle">
                                {{__('Overview')}}
                            </div>
                            <h2 class="page-title">
                                @yield('h1')
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <main>
                {{ $slot }}
            </main>
            @include('layouts.footer')
        </div>
    </div>
    @include('layouts.scripts')
</body>

</html>
