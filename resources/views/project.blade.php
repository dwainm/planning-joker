<x-layout>
	<ul>
		@if (empty($issues))
			<p>No issues found</p>
		@else
			@foreach ($issues as $issue)
				<li> {{ $issue["id"] }} - {{ $issue["title"] }} - {{ $issue["fields"]["estimate"] }} </li>
			@endforeach
		@endif
</x-layout>
