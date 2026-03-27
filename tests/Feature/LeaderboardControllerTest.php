<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\QuestionTeam;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaderboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_scores_index_displays_all_games(): void
    {
        Game::create(['name' => 'Alpha', 'is_open' => true]);
        Game::create(['name' => 'Beta', 'is_open' => false]);

        $response = $this->get('/scores');

        $response->assertOk();
        $response->assertViewIs('score_index');
        $response->assertViewHas('games', fn ($games) => $games->count() === 2);
    }

    public function test_scores_show_sorts_teams_by_score_descending(): void
    {
        $game = Game::create(['name' => 'Main', 'is_open' => true]);

        $teamLow = Team::create(['game_id' => $game->id, 'name' => 'Low', 'code' => 'L-1']);
        $teamHigh = Team::create(['game_id' => $game->id, 'name' => 'High', 'code' => 'H-1']);

        QuestionTeam::create([
            'team_id' => $teamLow->id,
            'points' => 1,
            'started_at' => now(),
            'finished_at' => now(),
        ]);

        QuestionTeam::create([
            'team_id' => $teamHigh->id,
            'points' => 6,
            'started_at' => now(),
            'finished_at' => now(),
        ]);

        $response = $this->get('/scores/game/'.$game->id);

        $response->assertOk();
        $response->assertViewIs('score_game');
        $response->assertViewHas('teams', function (array $teams) use ($teamHigh, $teamLow) {
            return $teams[0]['id'] === $teamHigh->id
                && $teams[1]['id'] === $teamLow->id
                && isset($teams[0]['color']);
        });
    }
}
