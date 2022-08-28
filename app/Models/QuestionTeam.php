<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;


class QuestionTeam extends Pivot
{
    public $incrementing = true;

    protected $casts = [
        'started_at' => 'datetime',
        'scans' => 'array'
    ];
}
