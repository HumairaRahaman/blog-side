<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('meta')">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="{{ asset('frontend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="{{ asset('frontend/css/clean-blog.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

    @yield('styles')

    <style type="text/css">
        .masthead {
            background-image: url('img/home-bg.jpg');
        }
    </style>

</head>

<body>

@include('frontend/layout/topnav')
@yield('content')


@include('frontend/layout/footer')

<!-- Bootstrap core JavaScript -->
<script src="{{ asset('frontend/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Custom scripts for this template -->
<script src="{{ asset('frontend/js/clean-blog.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js" ></script>

@yield('scripts')

</body>

</html>
