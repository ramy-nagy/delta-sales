@php
    app()->getLocale() == 'ar' ? $rtl = '.rtl': $rtl = '';
@endphp
<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
<!-- Styles -->
{{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.min.css') }}">
<!-- CSS files -->
<link rel="stylesheet" type="text/css" href="{{ asset("admin/css/tabler$rtl.min.css") }}" />
{{-- <link rel="stylesheet" type="text/css" href="{{ asset("admin/css/tabler-flags.min.css") }}" /> --}}
{{-- <link rel="stylesheet" type="text/css" href="{{ asset("admin/css/tabler-payments.min.css") }}" /> --}}
{{-- <link rel="stylesheet" type="text/css" href="{{ asset("admin/css/tabler-vendors.min.css") }}" /> --}}
<link rel="stylesheet" type="text/css" href="{{ asset("admin/css/demo$rtl.min.css") }}" />

@livewireStyles
