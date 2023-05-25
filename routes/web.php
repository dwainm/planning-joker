<?php
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GithubProjectsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use App\Models\VotingSession;
use Illuminate\Support\Facades\Route;

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
		return redirect('/dashboard');
});

Route::get('/dashboard', function () {
	ray(VotingSession::all()->toArray());
		return view('dashboard',
				[
				'title'=>'Welcome',
				'sessions'=> VotingSession::all()->toArray(),
				'projects'=> GithubProjectsController::get_projects(),
				]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::resource('sessions',SessionController::class)->middleware(['auth', 'verified']);
Route::post('sessions/{id}/votes','App\Http\Controllers\SessionController@saveVotes')->middleware(['auth', 'verified'])->name('sessions-votes');

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

require __DIR__.'/auth.php';
