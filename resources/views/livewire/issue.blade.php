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
		Current Estimate {{ $issue['github_issue_estimate'] }}
        @if ( ! empty( $issue['github_url'] ) )
            | <a target="_blank" href="{{$issue['github_url']}}">Link</a> |
        @endif
        Description: {!! $issue['github_issue_description'] !!}
		</p>
	 </div>
  </div>
        <div>
			 @foreach( [1,2,3,5,8,13,21] as $option )
                {{ $issue_vote = $votes[$issue['id']]['estimate']??''}}
				<input @checked($issue_vote==$option) type="radio" id="{{$issue['id']}}-estimate-{{$option}}" name="estimate[{{$issue['id']}}]" value="{{$option}}">
				<label for="{{$issue['id']}}-estimate-{{$option}}">{{$option}}</label>
			@endforeach
        </div>
</li>
