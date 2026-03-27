<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_login_without_team_session(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_root_loads_home_for_logged_in_team(): void
    {
        $game = Game::create([
            'name' => 'Forest',
            'is_open' => true,
        ]);

        $team = Team::create([
            'game_id' => $game->id,
            'name' => 'Wolves',
            'code' => 'WOLF-1',
        ]);

        $response = $this->withSession(['team_id' => $team->id])->get('/');

        $response->assertOk();
        $response->assertViewIs('home');
        $response->assertViewHas('team', fn (Team $viewTeam) => $viewTeam->is($team));
    }
}

