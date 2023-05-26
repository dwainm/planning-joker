<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use App\Models\VotingSessionIssue;
use App\Models\VotingSession;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VotesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('voting_session_votes')->insert($this->vote());
    }

    /**
     * Generate a user for the seeder
     */
    public function vote():array
    {
        return [
            'user_id'    => $this->uid(),
            'session_id' => $this->sesid(),
            'issue_id'   => $this->issueid(),
            'estimate'   => $this->est(),
            'created_at' => $this->now(),
            'updated_at' => $this->now(),
        ];
    }

    public function s():string
    {
        return Str::random(10);
    }

    public function sesid():string
    {
        return VotingSession::all()->random()->id;
    }

    public function issueid():string
    {
        return VotingSessionIssue::all()->random()->id;
    }

    public function uid():string
    {
        return User::all()->random()->id;
    }

    /**
     * MysQl compatible date time string of the current time
     */
    public function est():string
    {
        $estimates = [1,2,3,5,8,13,21];
        $ran_index = rand(0,6);
        return $estimates[$ran_index];
    }

    /**
     * MysQl compatible date time string of the current time
     */
    public function now():string
    {
        return Carbon::now()->toDateTimeString();
    }
}
