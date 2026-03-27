<?php

namespace Tests\Unit;

use App\Models\Game;
use App\Models\Question;
use App\Models\QuestionTeam;
use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_game_has_many_teams_relation(): void
    {
        $relation = (new Game())->teams();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertSame(Team::class, $relation->getRelated()::class);
    }

    public function test_team_relations_are_configured(): void
    {
        $team = new Team();

        $this->assertInstanceOf(BelongsTo::class, $team->game());
        $this->assertInstanceOf(BelongsToMany::class, $team->questions());
        $this->assertInstanceOf(HasMany::class, $team->answers());
    }

    public function test_question_has_many_to_many_teams_relation(): void
    {
        $relation = (new Question())->teams();

        $this->assertInstanceOf(BelongsToMany::class, $relation);
        $this->assertSame(Team::class, $relation->getRelated()::class);
    }

    public function test_question_team_belongs_to_team_and_question(): void
    {
        $pivot = new QuestionTeam();

        $this->assertInstanceOf(BelongsTo::class, $pivot->team());
        $this->assertInstanceOf(BelongsTo::class, $pivot->question());
    }
}
