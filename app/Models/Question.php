<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public function teams()
    {
        return $this->belongsToMany(Team::class)->using(QuestionTeam::class)->withPivot('started_at', 'finished_at', 'points', 'answer_given', 'num_scans');
    }
}
