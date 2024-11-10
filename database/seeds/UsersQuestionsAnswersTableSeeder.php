<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\DB;

class UsersQuestionsAnswersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('answers')->delete();
        DB::table('questions')->delete();
        DB::table('users')->delete();

        User::factory()->count(3)->create()->each(function($u) {
            $u->questions()
                ->saveMany(
                    Question::factory()->count(rand(1, 5))->make()
                )
                ->each(function ($q) {
                    $q->answers()->saveMany(Answer::factory()->count(rand(1, 5))->make());
                });
        });
    }
}

