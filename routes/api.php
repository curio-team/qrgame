<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Game;
use App\Models\Team;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/game/{game}/scores', function (Game $game) {
    $teams = $game->teams->map(fn ($t) => [
        'id' => $t->id,
        'name' => $t->name,
        'score' => $t->score,
    ])->sortByDesc('score')->values();

    return response()->json($teams);
});

Route::get('/team/{team}/score', function (Team $team) {
    return response()->json([
        'id' => $team->id,
        'name' => $team->name,
        'score' => $team->score,
    ]);
});
