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
        // $teams = $game->teams->sortBy('score', SORT_NUMERIC);
        $teams = $game->teams->sortBy(function ($team, $key) {
            return $team->getScoreAttribute();
        }, SORT_NUMERIC);
        $teams->values()->all();
        return $teams;//->get();
        //return view('score_game')->with(compact('game'))->with(compact('teams'));
    }
}
