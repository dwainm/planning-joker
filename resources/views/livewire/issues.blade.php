<div>
	@if (empty($issues))
			<p>No issues found</p>
	@else
		@foreach ($issues as $issue)
			@livewire('issue', ['issue'=>$issue])
		@endforeach
	@endif
</div>
