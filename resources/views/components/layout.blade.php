<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Planning Joker - {{ $title?? 'App' }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    </head>
		<body>
		<header class="container">
			<h1>{{ $title?? 'App' }}</h1>
		</header>
		<main class="container">
			{{ $slot }}
		</main>
	</body>
</html>
