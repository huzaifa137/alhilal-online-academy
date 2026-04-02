<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta content="AlHilal Online Academy" name="description">
    <meta content="Spruko Technologies Private Limited" name="author">
    <meta name="keywords" content="UP" />
    @include('layouts.custom-head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    .swal2-popup {
        background: #783896 !important;
        color: #ffffff !important; /* optional */
    }
    .swal2-styled.swal2-confirm {
        background-color: #ffffff !important;
        color: #D8382E !important;
    }
</style>
</head>


<body class="h-100vh page-style1 light-mode">
    @yield('content')
    @include('layouts.custom-footer-scripts')
</body>

</html>
