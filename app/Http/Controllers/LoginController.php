<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(['code' => 'required']);
        $team = Team::where('code', $request->code)->first();
        if(!$team) return redirect('/login');
        $request->session()->put('team_id', $team->id);
        return redirect('/');
    }

    public function home(Request $request)
    {
        return view('home')->with('team', Team::find($request->session()->get('team_id')));
    }
}
