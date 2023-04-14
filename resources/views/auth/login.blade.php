<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

	<div class="text-center">
		<a href="{{ route('github.login') }}">
			{{-- <img src="{{ asset('images/github_black_logo_icon.png') }}"
			alt="Github Icon"
			width="30px"
			class="mx-4 scale-100 hover:scale-125 ease-in duration-200"> --}}
            <x-primary-button class=" flex rounded px-6
			py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg">
                {{ __('Log in with GIthub') }}
            </x-primary-button>
		</a>
	</div>
</x-guest-layout>
