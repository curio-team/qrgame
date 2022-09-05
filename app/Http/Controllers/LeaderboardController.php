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

        $fromHigh = $game->teams->count();
        array_walk($teams, [$this, 'mapColor'], $fromHigh);

        return view('score_game')->with(compact('game'))->with(compact('teams'));
    }

    public function mapColor(&$team, $key, $fromLow) {
        $toLow = 95;
        $toHigh = 25;
        $fromHigh = 1;

        $fromRange = $fromHigh - $fromLow;
        $toRange = $toHigh - $toLow;
        $scaleFactor = $toRange / $fromRange;
    
        // Re-zero the value within the from range
        $tmpValue = ($key+1) - $fromLow;
        // Rescale the value to the to range
        $tmpValue *= $scaleFactor;
        // Re-zero back to the to range
        $team['color'] = $tmpValue + $toLow;
    }
}
