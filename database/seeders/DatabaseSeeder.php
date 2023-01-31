<?php

namespace Database\Seeders;

use App\Models\Show;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => "Chris Admin",
            'email' => "chris@fantata.com",
            'password' => Hash::make('TestPass99!'),
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => "Chris Read",
            'email' => "fantata@gmail.com",
            'password' => Hash::make('TestPass99!'),
        ]);

        Show::factory(['user_id' => 2])->count(3)->hasEpisodes(10)->create();

        Category::create([
            'name' => 'Business'
        ]);

        Category::create([
            'name' => 'Sports'
        ]);

        Category::create([
            'name' => 'Arts'
        ]);

        Category::create([
            'name' => 'Comedy'
        ]);

        Category::create([
            'name' => 'Education'
        ]);

        Category::create([
            'name' => 'Fiction'
        ]);
    }
}
