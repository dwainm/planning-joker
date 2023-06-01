<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Inertia\Inertia;

class GithubController extends Controller
{
    public  function redirect()
	{
		$url = Socialite::driver('github')
		->scopes(['project','repo'])
		->redirect()->getTargetUrl();
        return Inertia::location($url);
	}

	public function callback()
	{
		$githubUser = Socialite::driver('github')->stateless()->user();
        $user = $this->regesiterOrGetUser( $githubUser);

		Auth::login($user);

        return to_route('index');
	}

    /**
     * For a given github user register or fin existing user
     * @param $githubUser
     *
     * @return \App\Models\User $user
     */
    private function regesiterOrGetUser( $githubUser ){
		$user = User::where('github_id','=',$githubUser->id)->first();
		if ( empty( $user ) )
		{
			$hashed_random_password = Hash::make(Str::random(8));

			$data = [
				'name' => $githubUser->name,
				'email' => $githubUser->email,
				'password' => $hashed_random_password,
				'auth_type' => 'github',
				'nickname' => $githubUser->nickname,
				'github_id' => $githubUser->id,
				'gh_token' => Crypt::encryptString($githubUser->token)
			];
			$user = User::updateOrCreate($data);
		} else {
			// update user with the latest data
			$user->update([
				'name' => $githubUser->name,
				'email' => $githubUser->email,
				'gh_token' => Crypt::encryptString($githubUser->token)
			]);
		}

        return $user;
    }
}
