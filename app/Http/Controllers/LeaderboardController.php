<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class LeaderboardController extends Controller
{
    public function index()
    {
        $games = Game::all();
        return view('score_index')->with(compact('games'));
    }

    public function show(Game $game)
    {   
        $teams = $game->teams->toArray();
        usort($teams, function ($a, $b){
            return intval($b['score']) <=> intval($a['score']);
        });

        $from = [$game->teams->min('score'), $game->teams->max('score')];
        array_walk($teams, [$this, 'mapColor'], $from);

        return view('score_game')->with(compact('game'))->with(compact('teams'));
    }

    public function mapColor(&$team, $key, $from) {
        $toLow = 95;
        $toHigh = 25;
        $fromLow = $from[0];
        $fromHigh = $from[1];

        $fromRange = $fromHigh - $fromLow;
        $toRange = $toHigh - $toLow;
        $scaleFactor = $toRange / $fromRange;
    
        // Re-zero the value within the from range
        $tmpValue = $team['score'] - $fromLow;
        // Rescale the value to the to range
        $tmpValue *= $scaleFactor;
        // Re-zero back to the to range
        $team['color'] = $tmpValue + $toLow;
    }
}
