<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GithubProjectsController;
use App\Models\VotingSession;
use App\Models\VotingSessionIssue;
use App\Models\votingSessionVote;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use function Pest\Laravel\withoutEvents;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		echo "hi";
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
	   $project_id = $request->input('github-project-id-select');
	   $issues = GithubProjectsController::get_project_issues($project_id);

	   if (empty( $issues ) ) {
		   abort( '403', __( "This project contains no issues. We can not start a session for it." ) );
	   }

	   // Not thes will need to be moved to the profile or project settings
	   // when whe have that, for no this is a quick and dirty way to get the project estimate
	   // field in order for us to save the vote results.
	   // Get the first on as all estimate field ides for this project will be the same.
	   $estimate_field_id = $issues[0]['fields']['estimate']['id'];

	   $session = new VotingSession();
	   $session->is_active = true;
	   $session->end_date = Carbon::now()->addWeek()->toDateTimeString();
	   $session->github_project_id = $project_id;
	   $session->github_estimate_field_id = $estimate_field_id;
	   $session->save();

	   foreach( $issues as $issue ) {
		   $sessionIssue                           = new VotingSessionIssue();
		   $sessionIssue->voting_session_id        = $session->id;
		   $sessionIssue->github_issue_id          = $issue['id'];
		   $sessionIssue->github_issue_title       = $issue['title'];
		   $sessionIssue->github_url               = $issue['url'];
		   $sessionIssue->github_issue_description = $issue['description'];
		   $sessionIssue->is_active                = true;
		   $sessionIssue->github_issue_estimate    = $issue['fields']['estimate']['value'];
		   $sessionIssue->save();
	   }

	   $request->session()->flash('status', 'session-created');
	   return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show($VotingSessionId)
    {
		$VotingSession = VotingSession::findOrFail($VotingSessionId);
		$issues = VotingSessionIssue::all()->where('voting_session_id',$VotingSession->id);
		$votes  = votingSessionVote::where(['session_id'=>$VotingSessionId, 'user_id'=> request()->user()->id])->get()->toArray();
		$issue_votes = [];
		foreach( $votes as $vote ){
			$issue_votes[$vote['issue_id']] = $vote;
		}

        // setting status
        // If a date is null now() will be equal to the date so session still
        // be active.
        $now = Carbon::now();
        if ( $now > Carbon::parse( $VotingSession->end_date ) ) {
            $is_closed = true;
            $status_message = __('The session has expired and Voting is closed');
        } elseif ( $now > Carbon::parse( $VotingSession->manually_closed ) ) {
            $is_closed = true;
            $status_message = __('The session was ended by the author.');
        } elseif ( $now > Carbon::parse( $VotingSession->finalized_date ) ) {
            $is_closed = true;
            $status_message = __('The session has has already been finalized.');
        } else {
            $is_closed = false;
            $status_message = __('Session is active');
        }

        $status = [
            'is_closed'=>$is_closed,
            'message'=> $status_message
        ];

		return view('view-session', [
				'VotingSession'=>$VotingSession,
				'issues'=> $issues,
				'votes'=> $issue_votes,
                'status'=> $status,
				]);
    }

    /**
     * Display the specified resource.
     */
    public function showManage($VotingSessionId)
    {
		$VotingSession = VotingSession::findOrFail($VotingSessionId);
		$issues = VotingSessionIssue::all()->where('voting_session_id',$VotingSession->id);
		$votes  = votingSessionVote::where(['session_id'=>$VotingSessionId, 'user_id'=> request()->user()->id])->get()->toArray();
		$issue_votes = [];
		foreach( $votes as $vote ){
			$issue_votes[$vote['issue_id']] = $vote;
		}

        // setting status
        // If a date is null now() will be equal to the date so session still
        // be active.
        $now = Carbon::now();
        if ( $now > Carbon::parse( $VotingSession->end_date ) ) {
            $is_closed = true;
            $status_message = __('The session has expired and Voting is closed');
        } elseif ( $now > Carbon::parse( $VotingSession->manually_closed ) ) {
            $is_closed = true;
            $status_message = __('The session was ended by the author.');
        } elseif ( $now > Carbon::parse( $VotingSession->finalized_date ) ) {
            $is_closed = true;
            $status_message = __('The session has has already been finalized.');
        } else {
            $is_closed = false;
            $status_message = __('Session is active');
        }

        $status = [
            'is_closed'=>$is_closed,
            'message'=> $status_message
        ];

        if ( request()->user()->id != $VotingSession->creator_id ){
            abort(404);
        }

		return view('manage-session', [
				'VotingSession'=>$VotingSession,
				'issues'=> $issues,
				'votes'=> $issue_votes,
                'status'=> $status,
				]);
    }

    /**
     * Handle issue votes
     */
    public function saveVotes($sessionId)
    {
		$VotingSession = VotingSession::findOrFail($sessionId);
		$submitted_votes = $_POST['estimate'];
		$user_id = request()->user()->id;
		foreach( $submitted_votes as $id => $estimate ) {
			// create or update
			$vote = votingSessionVote::where(['user_id'=> $user_id, 'session_id'=>$VotingSession->id,'issue_id'=>$id])->first();
			$vote = $vote ?? new votingSessionVote();
			$vote->user_id = $user_id;
			$vote->session_id = $VotingSession->id;
			$vote->issue_id = $id;
			$vote->estimate = $estimate;
			$vote->save();
		}

		request()->session()->flash('status', 'vote-submitted');
		return back();
    }

    /**
     * Handle issue votes
     */
    public function finaliseEstimates($sessionId)
    {
		$VotingSession = VotingSession::findOrFail($sessionId);
		$submitted_votes = $_POST['estimate'];
		$VotingSessionIssues = VotingSessionIssue::whereIn( 'id', array_keys( $submitted_votes ))->get();
		$new_estimate_update = [];
		foreach( $VotingSessionIssues as $issue ) {
			if ( !isset ( $submitted_votes[$issue->id] ) ) {
				continue;
			}
			$new_estimate_update[$issue->github_issue_id] = $submitted_votes[$issue->id];
		}
		GithubProjectsController::update_estimate_values(
			$VotingSession->github_project_id,
			$VotingSession->github_estimate_field_id,
			$new_estimate_update
		);

		request()->session()->flash('status', 'vote-submitted');
		return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
	   return redirect("sessions/$id/manage");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VotingSession $VotingSession)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VotingSession $VotingSession)
    {
        //
    }
}
