<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $casts = ['score' => 'integer'];
    protected $appends = ['score'];


    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class)->using(QuestionTeam::class)->withPivot('started_at', 'finished_at', 'points', 'answer_given', 'num_scans');
    }

    public function getScoreAttribute()
    {
        return $this->questions()->sum('points');
    }
}
