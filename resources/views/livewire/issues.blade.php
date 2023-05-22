<div>
<form method="POST" action="/sessions/{{$VotingSession->id}}/votes">
	@csrf
	@if (empty($issues))
		<div class="flex items-center justify-center gap-10">
		<p>No issues found</p>
		</div>
	@else

		<ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700 space-x-9">
		@foreach ($issues as $issue)
			@livewire('issue', ['issue'=>$issue, 'votes'=>$votes])
			<hr class="w-ful h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">
		@endforeach
		</ul>
	@endif
	<div class="flex items-center gap-4">
		<x-primary-button>{{ __('Save') }}</x-primary-button>

		@if (session('status') === 'vote-submitted')
			<p
				x-data="{ show: true }"
				x-show="show"
				x-transition
				x-init="setTimeout(() => show = false, 2000)"
				class="text-sm text-gray-600 dark:text-gray-400"
			>{{ __('Vote Submitted') }}</p>
		@endif
	</div>
</form>
</div>
