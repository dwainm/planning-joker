<form method="POST" action="/sessions/{{$VotingSession->id}}/votes">
	@csrf

	@if (empty($issues))
		<div class="flex items-center justify-center gap-10">
		<p>No issues found</p>
		</div>
	@else

		@if (session('status') === 'vote-submitted')
            <div
				x-data="{ show: true }"
				x-show="show"
				x-transition
				x-init="setTimeout(() => show = false, 2000)"
				class="text-sm text-gray-600 dark:text-gray-400"
                >
                <br> <br>
			        <p> {{ __('Vote Submitted') }} </p>
                <br>
            </div>
		@endif
		<ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700 space-x-9">
		@foreach ($issues as $issue)
            <li class="pb-0">
              <div class="flex items-center space-x-30">
                 <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        {{ $issue['github_issue_title'] }}
                    </p>
                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                    Current Estimate {{ $issue['github_issue_estimate'] }}
                    @if ( ! empty( $issue['github_url'] ) )
                        | <a target="_blank" href="{{$issue['github_url']}}">Link</a> |
                    @endif Description: {!! $issue['github_issue_description'] !!}
                    </p>
                 </div>
              </div>

                    <div>
                         @foreach( [1,2,3,5,8,13,21] as $option )
                            @php($issue_vote = $votes[$issue['id']]['estimate']??'')
                            <input @checked($issue_vote==$option) type="radio" id="{{$issue['id']}}-estimate-{{$option}}" name="estimate[{{$issue['id']}}]" value="{{$option}}">
                            <label for="{{$issue['id']}}-estimate-{{$option}}">{{$option}}</label>
                        @endforeach
                    </div>
            </li>
			<hr class="w-ful h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">
		@endforeach
		</ul>
	@endif
	<div class="flex items-center gap-4">
	    <x-primary-button>{{ __('Submit') }}</x-primary-button>
	</div>
</form>
