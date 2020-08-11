<!doctype html>
<html lang="ja">

<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Reserve System</title>
@yield('library')
{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="{{ asset('js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
{{-- bootstrap --}}
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
{{-- css --}}
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@yield('styles')
</head>

<body>
<main>
    <div class="container">
        @yield('content')
    </div>
</main>
@yield('script')
</body>
</html>