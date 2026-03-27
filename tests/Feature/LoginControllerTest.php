<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_available(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertViewIs('login');
    }

    public function test_login_requires_code(): void
    {
        $response = $this->post('/login', []);

        $response->assertSessionHasErrors('code');
    }

    public function test_login_with_unknown_code_redirects_back_to_login(): void
    {
        $response = $this->post('/login', ['code' => 'missing']);

        $response->assertRedirect('/login');
        $this->assertNull(session('team_id'));
    }

    public function test_login_with_valid_code_stores_team_in_session(): void
    {
        $game = Game::create([
            'name' => 'Forest',
            'is_open' => true,
        ]);

        $team = Team::create([
            'game_id' => $game->id,
            'name' => 'Ravens',
            'code' => 'RAVEN-1',
        ]);

        $response = $this->post('/login', ['code' => $team->code]);

        $response->assertRedirect('/');
        $response->assertSessionHas('team_id', $team->id);
    }
}
