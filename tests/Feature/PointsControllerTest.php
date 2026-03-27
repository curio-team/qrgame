<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\QuestionTeam;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PointsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_points_index_and_game_pages_load(): void
    {
        $game = Game::create(['name' => 'Main', 'is_open' => true]);

        $indexResponse = $this->get('/points/add/');
        $indexResponse->assertOk();
        $indexResponse->assertViewIs('points_index');

        $showResponse = $this->get('/points/add/game/'.$game->id);
        $showResponse->assertOk();
        $showResponse->assertViewIs('points_show');
    }

    public function test_add_points_creates_question_team_record(): void
    {
        $game = Game::create(['name' => 'Main', 'is_open' => true]);
        $team = Team::create(['game_id' => $game->id, 'name' => 'Falcons', 'code' => 'F-1']);

        $response = $this->post('/points/add/game/'.$game->id, [
            'team' => $team->id,
            'points' => 7,
        ]);

        $response->assertRedirect('/points/add/game/'.$game->id);

        $this->assertDatabaseHas('question_team', [
            'team_id' => $team->id,
            'points' => 7,
        ]);

        $record = QuestionTeam::query()->where('team_id', $team->id)->firstOrFail();
        $this->assertNotNull($record->started_at);
        $this->assertNotNull($record->finished_at);
    }
}
