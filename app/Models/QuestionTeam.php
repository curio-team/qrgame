<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;


class QuestionTeam extends Pivot
{
    public $incrementing = true;

    protected $table = 'question_team';

    protected $fillable = [
        'question_id',
        'team_id',
        'started_at',
        'finished_at',
        'points',
        'answer_given',
        'scans',
    ];

    protected $casts = [
        'question_id' => 'integer',
        'team_id' => 'integer',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'points' => 'integer',
        'scans' => 'array'
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
