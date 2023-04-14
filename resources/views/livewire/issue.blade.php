<li class="pb-0 ">
  <div class="flex items-center space-x-30">
	 <div class="flex-shrink-0">
		<img class="w-8 h-8 rounded-full" src="{{ asset('images/github_black_logo_icon.png') }}" alt="Github logo">
	 </div>
	 <div class="flex-1 min-w-0">
		<p class="text-sm font-medium text-gray-900 truncate dark:text-white">
{{ $issue["title"] }}
		</p>
		<p class="text-sm text-gray-500 truncate dark:text-gray-400">
		Current Estimate {{ $issue["fields"]["estimate"] }}
		</p>
	 </div>
	 <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
	 ID: {{ $issue["id"] }}
	 </div>
      </div>
</li>

