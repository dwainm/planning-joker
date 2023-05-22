<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sessions Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
					@if(!empty($sessions) )
						@foreach ($sessions as $session)
							<li> <a href="sessions/{{ $session['id']}}">ID: {{$session['id']}} Voting End Date: {{ $session['end_date'] }}</a> </li>
						@endforeach
					@else
						<p> {{ __('No sessions') }} </p>
					@endif
					<form method="POST" action="/sessions">
						@csrf
						<div class="flex items-center gap-4">
							<select name="github-project-id-select" >
								<option>Select Project</option>
								@foreach ($projects as $project)
									<option value="{{$project->id}}">{{$project->title}}</option>
								@endforeach
							</select>
							<x-primary-button>{{ __('Create Session') }}</x-primary-button>

							@if (session('status') === 'session-created')
								<p
									x-data="{ show: true }"
									x-show="show"
									x-transition
									x-init="setTimeout(() => show = false, 2000)"
									class="text-sm text-gray-600 dark:text-gray-400"
								>{{ __('Session Created and Project Issues added.') }}</p>
							@endif
						</div>
					</form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
