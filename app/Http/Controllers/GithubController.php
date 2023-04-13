<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GithubController extends Controller
{
    public  function redirect()
	{
		return Socialite::driver('github')->redirect();
	}
	
	public function callback()
	{
		$githubUser = Socialite::driver('github')->stateless()->user();
		ray($githubUser);

		$hashed_random_password = Hash::make(Str::random(8));

		$data = [
        'name' => $githubUser->name,
        'email' => $githubUser->email,
		'password' => $hashed_random_password,
		'auth_type' => 'github',
		'nickname' => $githubUser->nickname,
		'github_id' => $githubUser->id,
		];
		ray($data);

		$user = User::updateOrCreate($data);
 
    Auth::login($user);
 
    return redirect('/dashboard');
	}
}
