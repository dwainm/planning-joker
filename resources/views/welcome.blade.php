<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    </head>
		<body>
		<header class="container">
		<h1>{{ $title }}</h1>
		</header>
		<main class="container">
			<ul>
			@foreach ($projects as $project)
				<li> <a href="project/{{ $project->id }}">{{ $project->title }}</a> </li>
			@endforeach
			</ul>
		</main>
	</body>
</html>
