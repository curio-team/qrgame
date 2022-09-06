<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Team;
use App\Models\QuestionTeam;

class PointsController extends Controller
{
    public function index()
    {
        $games = Game::all();
        return view('points_index')->with(compact('games'));
    }

    public function show(Game $game)
    {
        return view('points_show')->with(compact('game'));
    }

    public function add(Request $request, Game $game)
    {
        $q = new QuestionTeam();
        $q->team_id = $request->team;
        $q->started_at = \Carbon\Carbon::now();
        $q->finished_at = $q->started_at;
        $q->points = $request->points;
        $q->save();
        
        // return redirect('/points/add/game/' . $game->id);
    }
}
