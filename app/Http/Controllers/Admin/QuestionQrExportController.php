<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Http\Request;

class QuestionQrExportController extends Controller
{
    private const DEFAULT_QR_PUBLIC_URL = 'https://qr.curio.codes';

    public function index()
    {
        $questions = Question::query()
            ->orderBy('id')
            ->get(['id', 'slug', 'type', 'text']);

        return view('admin.questions.qr-export', compact('questions'));
    }

    public function print(Request $request)
    {
        $validated = $request->validate([
            'question_ids' => ['required', 'array', 'min:1'],
            'question_ids.*' => ['integer', 'distinct', 'exists:questions,id'],
        ]);

        $questions = Question::query()
            ->whereIn('id', $validated['question_ids'])
            ->orderBy('id')
            ->get(['id', 'slug', 'type', 'text']);

        $options = new QROptions(['eccLevel' => EccLevel::L]);
        $questions->transform(function (Question $question) use ($options) {
            $question->qr_url = $this->questionQrUrl($question);
            $question->qr_svg = (new QRCode($options))->render($question->qr_url);

            return $question;
        });

        return view('admin.questions.qr-export-print', compact('questions'));
    }

    private function questionQrUrl(Question $question): string
    {
        $baseUrl = rtrim((string) config('app.qr_public_url', self::DEFAULT_QR_PUBLIC_URL), '/');

        return $baseUrl.'/qr/'.$question->slug;
    }
}
