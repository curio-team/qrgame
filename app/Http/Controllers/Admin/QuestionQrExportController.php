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
        $qrCode = new QRCode($options);
        $questions->transform(function (Question $question) use ($qrCode) {
            $question->qr_svg = $qrCode->render(url('/qr/' . $question->slug));

            return $question;
        });

        return view('admin.questions.qr-export-print', compact('questions'));
    }
}
