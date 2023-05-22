<li class="pb-0">
  <div class="flex items-center space-x-30">
	 <div class="flex-shrink-0 mb-3">
	 {{--
		<img class="mr-20 w-8 h-8 rounded-full" src="{{ asset('images/github_black_logo_icon.png') }}" alt="Github logo">
		--}}
	 </div>
	 <div class="flex-1 min-w-0">
		<p class="text-sm font-medium text-gray-900 truncate dark:text-white">
			{{ $issue["title"] }}
		</p>
		<p class="text-sm text-gray-500 truncate dark:text-gray-400">
		Current Estimate {{ $issue["fields"]["estimate"]["value"] }}
		Field ID:  {{ $issue["fields"]["estimate"]["id"] }}
		</p>
	 </div>
  </div>
        <div>
		
		DWAIN
            <x-input-label for="estimate_{{ $issue["id"] }}" :value="__('New Estimate:')" />
			
            <input id="estimate_{{ $issue["id"] }}" name="estimate[{{ $issue["id"]}}]" type="radiotext" class="mt-1 block w-3" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>
</li>
