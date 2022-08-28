<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $game = \App\Models\Game::create([
            "name" => "Testgame",
            "is_open" => true
        ]);

        \App\Models\Team::create([
            "game_id" => $game->id,
            "name" => "Klas 1A",
            "code" => "a123"
        ]);

        \App\Models\Team::create([
            "game_id" => $game->id,
            "name" => "Klas 1B",
            "code" => "b123"
        ]);

        \App\Models\Question::create([
            "slug" => "1a",
            "type" => "assignment",
            "text" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam expedita, adipisci corrupti inventore nesciunt recusandae ipsa fugiat consequuntur dolores animi tenetur laborum, ratione odit atque! Minus in voluptate iste distinctio!"
        ]);

        \App\Models\Question::create([
            "slug" => "1b",
            "type" => "bomb"
        ]);

        \App\Models\Question::create([
            "slug" => "1c",
            "type" => "loot"
        ]);

        \App\Models\Question::create([
            "slug" => "1d",
            "type" => "question",
            "text" => "Wat is een programmeertaal?",
            "answer_a" => "Cobra",
            "answer_b" => "Python",
            "answer_c" => "Mamba",
            "correct_answer" => "b"
        ]);

        \App\Models\Question::create([
            "slug" => "1e",
            "type" => "flag"
        ]);
    }
}
