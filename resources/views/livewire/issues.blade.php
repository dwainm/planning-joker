@if (empty($issues))
<div class="flex items-center justify-center gap-10">
		<p>No issues found</p>
</div>
@else

<ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700 space-x-9">
	@foreach ($issues as $issue)
		@livewire('issue', ['issue'=>$issue])
	@endforeach
</ul>
@endif
