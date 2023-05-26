<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert($this->user());
    }

    /**
     * Generate a user for the seeder
     */
    public function user():array
    {

        return [
            'name'              => $this->s(),
            'email'             => $this->e(),
            'email_verified_at' => $this->now(),
            'password'          => $this->s(),
            'remember_token'    => $this->s(),
            'created_at'        => $this->now(),
            'updated_at'        => $this->now(),
            'nickname'          => $this->s(),
            'github_id'         => $this->s(),
            'auth_type'         => 'github',
            'gh_token'          => $this->s(),
        ];
    }

    public function s():string
    {
        return Str::random(10);
    }

    /**
     * Return random email
     */
    public function e():string
    {
        return $this->s() . '@rtes.test';
    }

    /**
     * MysQl compatible date time string of the current time
     */
    public function now():string
    {
        return Carbon::now()->toDateTimeString();
    }
}

