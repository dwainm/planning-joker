<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
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

		$hashed_random_password = Hash::make(Str::random(8));

		$user = User::updateOrCreate([
        'github_id' => $githubUser->id,
    ], [
        'name' => $githubUser->name,
        'email' => $githubUser->email,
        'github_token' => $_GET['code'],
		'password' => $hashed_random_password,
		'auth_type' => 'github',
    ]);
 
    Auth::login($user);
 
    return redirect('/dashboard');
	}
}
