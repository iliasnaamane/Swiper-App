<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>INSPIRE</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/css/app.css">
    <script src="/js/app.js"></script>
</head>
<body id="app">

<div class="header-container">
    <header class="wrapper clearfix">

    </header>
</div>

<div class="main-container">
    <div class="main wrapper clearfix">
        @yield('main')
    </div> <!-- #main -->
</div> <!-- #main-container -->

<div class="footer-container">
    <footer class="wrapper">

    </footer>
</div>

</body>

@stack('scripts')

<script type="text/javascript" src="/js/map.js"></script>
</html>