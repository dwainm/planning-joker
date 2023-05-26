<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $status['message'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

<form method="POST" action="/sessions/{{$VotingSession->id}}/finalize">
	@csrf

	@if (empty($issues))
		<div class="flex items-center justify-center gap-10">
		<p>No issues found</p>
		</div>
	@else

		@if (session('status') === 'session-finalized')
            <div
				x-data="{ show: true }"
				x-show="show"
				x-transition
				x-init="setTimeout(() => show = false, 2000)"
				class="text-sm text-gray-600 dark:text-gray-400"
                >
                <br> <br>
			        <p> {{ __('Votes updated on Github projects.') }} </p>
                <br>
            </div>
		@endif
		<ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700 space-x-9">
		@foreach ($issues as $issue)
            <li class="pb-0">
              <div class="flex items-center space-x-30">
                 <div class="flex-shrink-0 mb-3">
                 {{--
                    <img class="mr-20 w-8 h-8 rounded-full" src="{{ asset('images/github_black_logo_icon.png') }}" alt="Github logo">
                    --}}
                 </div>
                 <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        {{ $issue['github_issue_title'] }}
                    </p>
                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                    @php($issue_votes = $votes[$issue['id']]['estimate']??'')
                    Current Estimate {{ $issue['github_issue_estimate'] }}
                    @if ( ! empty( $issue['github_url'] ) )
                        | <a target="_blank" href="{{$issue['github_url']}}">Link</a> |
                    @endif Description: {!! $issue['github_issue_description'] !!}
                    </p>
                 </div>
              </div>
                    <ul>
                        @php( $common_vote = 0 )
                        @php( $previous = 0 )
                        @foreach($votes[$issue['id']] as $vote)
                            @if( $previous == $vote['estimate'])
                                @php( $common_vote = $vote['estimate'])
                            @else
                                @php( $previous = $vote['estimate'])
                                @php( $common_vote = 0)
                            @endif
                        @endforeach

                        @if( $common_vote!=0 )
                            😲 Unanimous!'
                        @else
                            @foreach($votes[$issue['id']] as $vote)
                                 <li>{{ \App\Models\User::find($vote['user_id'])->name}}: {{$vote['estimate']}}</li>
                            @endforeach
                        @endif
                    </ul>
                    <div>
                         @foreach( [1,2,3,5,8,13,21] as $option )
                            <input
                            class="{{ $common_vote!=0 ? 'grayscale' : '' }}"
                            @checked($common_vote==$option)
                            type="radio"
                            id="{{$issue['id']}}-estimate-{{$option}}"
                            name="estimate[{{$issue['id']}}]" value="{{$option}}" />

                            <label for="{{$issue['id']}}-estimate-{{$option}}">{{$option}}</label>
                        @endforeach
                    </div>
            </li>
            <br>
			<hr class="w-ful h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">
			<hr class="w-ful h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">
            <br>
			<hr class="w-ful h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">
			<hr class="w-ful h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">
			<hr class="w-ful h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">
            <br>
		@endforeach
		</ul>
	@endif
	<div class="flex items-center gap-4">
        <a type="button" href="{{ route("sessions.show", $VotingSession->id) }}" type="button"> View Session </a>
        <br>
		<x-primary-button>{{ __('Finalize') }}</x-primary-button>
	</div>
</form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
