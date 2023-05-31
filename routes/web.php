<?php
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GithubProjectsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use App\Models\VotingSession;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (! Auth::check()) {
        return redirect('login');
    }

    return Inertia::render('Index', [
        'sessions'=> VotingSession::all()->toArray(),
        'projects'=> GithubProjectsController::get_projects(),
    ]);
})->middleware(['auth', 'verified'])->name('home');


Route::resource('sessions',SessionController::class)->middleware(['auth', 'verified']);
Route::post('sessions/{id}/votes','App\Http\Controllers\SessionController@saveVotes')->middleware(['auth', 'verified'])->name('sessions-votes');
Route::get('sessions/{id}/manage','App\Http\Controllers\SessionController@showManage')->middleware(['auth', 'verified'])->name('show-manage');
Route::post('sessions/{id}/finalize','App\Http\Controllers\SessionController@finaliseEstimates')->middleware(['auth', 'verified'])->name('show-manage');

Route::get('/projects/{id}','App\Http\Controllers\GithubProjectsController@showProject')->middleware(['auth', 'verified'])->name('show-projects');
Route::post('/projects/{id}', function ($id){
	$field_id = "PVTF_lAHOABolQs2J4s4CTh_w"; // temporary harcoded untill settings is implemented where w
	GithubProjectsController::update_estimate_values($id,$field_id, $_POST['estimate']??[]);
	return redirect('/project/'. $id );

});


/** Auth Routes */
Route::get('/auth/github', [GithubController::class, 'redirect'])->name('github.login');
Route::get('/auth/github/callback', [GithubController::class, 'callback']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
