<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\Question;
use App\Models\QuestionTeam;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QrControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createTeamWithSession(): Team
    {
        $game = Game::create([
            'name' => 'Forest',
            'is_open' => true,
        ]);

        return Team::create([
            'game_id' => $game->id,
            'name' => 'Foxes',
            'code' => 'FOX-1',
        ]);
    }

    public function test_show_returns_error_view_for_unknown_slug(): void
    {
        $team = $this->createTeamWithSession();

        $response = $this->withSession(['team_id' => $team->id])->get('/qr/unknown');

        $response->assertOk();
        $response->assertViewIs('error');
        $response->assertViewHas('msg');
    }

    public function test_show_creates_pivot_and_returns_question_view_for_question_type(): void
    {
        $team = $this->createTeamWithSession();

        $question = Question::create([
            'slug' => 'q-1',
            'type' => 'question',
            'text' => '2 + 2?',
            'correct_answer' => '4',
        ]);

        $response = $this->withSession(['team_id' => $team->id])->get('/qr/'.$question->slug);

        $response->assertOk();
        $response->assertViewIs('question1');

        $this->assertDatabaseHas('question_team', [
            'team_id' => $team->id,
            'question_id' => $question->id,
        ]);
    }

    public function test_answering_question_is_case_insensitive_and_awards_points(): void
    {
        $team = $this->createTeamWithSession();

        $question = Question::create([
            'slug' => 'q-2',
            'type' => 'question',
            'text' => 'Forest king?',
            'correct_answer' => 'Wolf',
        ]);

        $this->withSession(['team_id' => $team->id])->get('/qr/'.$question->slug);

        $response = $this->withSession(['team_id' => $team->id])->get('/question/'.$question->slug.'/wOlF');

        $response->assertOk();
        $response->assertViewIs('question2');

        $this->assertDatabaseHas('question_team', [
            'team_id' => $team->id,
            'question_id' => $question->id,
            'answer_given' => 'wOlF',
            'points' => 2,
        ]);
    }

    public function test_loot_can_only_be_finished_once(): void
    {
        $team = $this->createTeamWithSession();

        $question = Question::create([
            'slug' => 'loot-1',
            'type' => 'loot',
        ]);

        $this->withSession(['team_id' => $team->id])->get('/qr/'.$question->slug);

        $response = $this->withSession(['team_id' => $team->id])->get('/loot/'.$question->slug);
        $response->assertOk();
        $response->assertViewIs('loot2');

        $pivot = QuestionTeam::query()
            ->where('team_id', $team->id)
            ->where('question_id', $question->id)
            ->firstOrFail();

        $this->assertNotNull($pivot->finished_at);
        $this->assertGreaterThanOrEqual(-3, $pivot->points);
        $this->assertLessThanOrEqual(5, $pivot->points);

        $response = $this->withSession(['team_id' => $team->id])->get('/loot/'.$question->slug);
        $response->assertRedirect('/qr/'.$question->slug);
    }

    public function test_assignment_marks_answer_as_finished(): void
    {
        $team = $this->createTeamWithSession();

        $question = Question::create([
            'slug' => 'assignment-1',
            'type' => 'assignment',
        ]);

        $this->withSession(['team_id' => $team->id])->get('/qr/'.$question->slug);

        $response = $this->withSession(['team_id' => $team->id])->get('/assignment/'.$question->slug);

        $response->assertOk();
        $response->assertViewIs('assignment2');

        $this->assertDatabaseHas('question_team', [
            'team_id' => $team->id,
            'question_id' => $question->id,
        ]);

        $this->assertNotNull(
            QuestionTeam::query()
                ->where('team_id', $team->id)
                ->where('question_id', $question->id)
                ->firstOrFail()
                ->finished_at
        );
    }
}
