<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionQrExportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_print_uses_public_qr_urls_for_each_selected_question(): void
    {
        config()->set('app.qr_public_url', 'https://qr.curio.codes/');

        $user = User::factory()->create();
        $firstQuestion = Question::create([
            'slug' => '2ok',
            'type' => 'question',
            'text' => 'First question',
            'correct_answer' => 'yes',
        ]);
        $secondQuestion = Question::create([
            'slug' => 'abc',
            'type' => 'loot',
        ]);
        $excludedQuestion = Question::create([
            'slug' => 'skip-me',
            'type' => 'flag',
        ]);

        $response = $this->actingAs($user)->get(route('admin.questions.qr-export.print', [
            'question_ids' => [$firstQuestion->id, $secondQuestion->id],
        ]));

        $response->assertOk();
        $response->assertViewIs('admin.questions.qr-export-print');
        $response->assertSee('https://qr.curio.codes/qr/2ok', false);
        $response->assertSee('https://qr.curio.codes/qr/abc', false);
        $response->assertDontSee('https://qr.curio.codes/qr/skip-me', false);
        $response->assertViewHas('questions', function ($questions) use ($firstQuestion, $secondQuestion, $excludedQuestion) {
            return $questions->pluck('slug')->all() === [$firstQuestion->slug, $secondQuestion->slug]
                && $questions->pluck('qr_url')->all() === [
                    'https://qr.curio.codes/qr/2ok',
                    'https://qr.curio.codes/qr/abc',
                ]
                && ! $questions->contains('slug', $excludedQuestion->slug)
                && $questions->every(fn (Question $question) => filled($question->qr_svg));
        });
    }

    public function test_print_view_keeps_the_3_by_4_page_layout(): void
    {
        $user = User::factory()->create();
        $question = Question::create([
            'slug' => '2ok',
            'type' => 'question',
            'text' => 'First question',
            'correct_answer' => 'yes',
        ]);

        $response = $this->actingAs($user)->get(route('admin.questions.qr-export.print', [
            'question_ids' => [$question->id],
        ]));

        $response->assertOk();
        $response->assertSee('grid-template-columns: repeat(3, 1fr);', false);
        $response->assertSee('grid-template-rows: repeat(4, 1fr);', false);
    }
}
