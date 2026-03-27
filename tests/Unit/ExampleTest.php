<?php

namespace Tests\Unit;

use App\Models\Game;
use App\Models\QuestionTeam;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_score_is_sum_of_answer_points(): void
    {
        $game = Game::create([
            'name' => 'Forest',
            'is_open' => true,
        ]);

        $team = Team::create([
            'game_id' => $game->id,
            'name' => 'Owls',
            'code' => 'OWL-1',
        ]);

        QuestionTeam::create([
            'team_id' => $team->id,
            'points' => 4,
            'started_at' => now(),
            'finished_at' => now(),
        ]);

        QuestionTeam::create([
            'team_id' => $team->id,
            'points' => -1,
            'started_at' => now(),
            'finished_at' => now(),
        ]);

        $this->assertSame(3, $team->fresh()->score);
    }
}

