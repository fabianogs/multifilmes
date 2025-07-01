<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<title>Multifilmes | Window Film</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta charset="UTF-8">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap"
		rel="stylesheet">
	<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('media/favicons/apple-touch-icon-57x57.png') }}">
	<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('media/favicons/apple-touch-icon-60x60.png') }}">
	<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('media/favicons/apple-touch-icon-72x72.png') }}">
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('media/favicons/apple-touch-icon-76x76.png') }}">
	<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('media/favicons/apple-touch-icon-114x114.png') }}">
	<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('media/favicons/apple-touch-icon-120x120.png') }}">
	<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('media/favicons/apple-touch-icon-144x144.png') }}">
	<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('media/favicons/apple-touch-icon-152x152.png') }}">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('media/favicons/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('media/favicons/android-chrome-192x192.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('media/favicons/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('media/favicons/manifest.json') }}">
	<link rel="mask-icon" href="{{ asset('media/favicons/safari-pinned-tab.svg') }}" color="#ffffff">
	<meta name="apple-mobile-web-app-title" content="">
	<meta name="application-name" content="">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="{{ asset('media/favicons/mstile-144x144.png') }}">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" href="{{ asset('css/main.css') }}">
	<script src="{{ asset('js/main.js') }}"></script>
</head>

<body>
	@include('layouts.header')
	@yield('content')
	@include('layouts.footer')
</body>

</html>