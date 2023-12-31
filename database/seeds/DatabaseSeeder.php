<?php

namespace Database\Seeders;

use FavoritesTableSeeder;
use Illuminate\Database\Seeder;
use UsersQuestionsAnswersTableSeeder;
use VotablesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersQuestionsAnswersTableSeeder::class,
            FavoritesTableSeeder::class,
            VotablesTableSeeder::class,
        ]);
    }
}
