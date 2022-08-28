<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Question;
use \App\Models\Team;
use \App\Models\QuestionTeam;

class QrController extends Controller
{
    public function show(Request $request, $slug)
    {
        $team = Team::find($request->session()->get('team_id'));
        $question = Question::where('slug', $slug)->first();

        //Check of vraag bestaat
        if(!$question) return view('error')->with(compact('team'))->with('msg', 'Ongeldige code, vraag niet gevonden.');

        //Check of er al een antwoord is, anders leeg antwoord maken
        $answer = QuestionTeam::where('question_id', $question->id)->where('team_id', $team->id)->first();
        if(!$answer)
        {
            $team->questions()->attach($question->id);
            $answer = QuestionTeam::where('question_id', $question->id)->where('team_id', $team->id)->first();
        }

        //Check of het een vlagtype is
        if($question->type == "flag")
        {
            return $this->flag($team, $question, $answer);
        }
        elseif($question->type == "bomb")
        {
            $rand = rand(1,3);
            $answer->points = $answer->points - $rand;
            $answer->save();
            return view('bomb')->with(compact('answer'))->with(compact('rand'))->with(compact('team'));
        }
        elseif($question->type == "loot")
        {
            //Check of vraag voor dit team nog niet is afgelopen 
            if($answer->finished_at == null)
            {
                return view('loot1')->with(compact('question'))->with(compact('team'));
            }
            else
            {
                return view('loot2')->with(compact('answer'))->with(compact('team'))->with('stale', true);
            }
        }
        elseif($question->type == "assignment")
        {
            if($answer->finished_at == null)
            {
                return view('assignment1')->with(compact('question'))->with(compact('team'));
            }
            else
            {
                return view('assignment1')->with(compact('question'))->with(compact('team'))->with('stale', true);
            }
        }
        elseif($question->type == "question")
        {
            //Check of vraag voor dit team nog niet is afgelopen 
            if($answer->finished_at == null)
            {
                return view('question1')->with(compact('question'))->with(compact('team'));
            }
            else
            {
                return view('question2')->with(compact('answer'))->with(compact('team'))->with(compact('question'))->with('stale', true);
            }
        }
    }

    private function flag($team, $question, $answer)
    {
        // Check of tijd om is:
        $end = $answer->started_at->addMinutes(5)->subHours(2);
        if($end <= \Carbon\Carbon::now() || $answer->finished_at != null)
        {
            $answer->finished_at = \Carbon\Carbon::now();
            $answer->save();
            return view('flag2')->with(compact('answer'))->with(compact('team'));
        }

        $ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
        $scans = $answer->scans ?? [];
        if(!in_array($ip, $scans))
        {
            $answer->scans = array_merge($scans, [$ip]);
            $answer->save();
        }

        // Check of er genoeg scans zijn gemaakt:
        if(count($answer->scans) >= 10)
        {
            $answer->finished_at = \Carbon\Carbon::now();
            $answer->points = 5;
            $answer->save();
            return view('flag2')->with(compact('answer'))->with(compact('team'));
        }

        return view('flag1')->with(compact('answer'))->with(compact('team'))->with('time', $end->diffForHumans(null, \Carbon\CarbonInterface::DIFF_ABSOLUTE, false, 3));
    }

    public function loot(Request $request, $slug)
    {
        $team = Team::find($request->session()->get('team_id'));
        $question = Question::where('slug', $slug)->where('type', 'loot')->first();

        //Check of vraag bestaat
        if(!$question) return view('error')->with(compact('team'))->with('msg', 'Ongeldige code, vraag niet gevonden.');

        //Check of er al een antwoord is, anders redirecten
        $answer = QuestionTeam::where('question_id', $question->id)->where('team_id', $team->id)->first();
        if(!$answer) return redirect('/qr/' . $question->slug);

        //Check of vraag voor dit team nog niet is afgelopen 
        if($answer->finished_at != null) return redirect('/qr/' . $question->slug);

        $rand = rand(-3,5);
        
        $answer->points = $rand;
        $answer->finished_at = \Carbon\Carbon::now();
        $answer->save();
        return view('loot2')->with(compact('answer'))->with(compact('team'));
    }

    public function assignment(Request $request, $slug)
    {
        $team = Team::find($request->session()->get('team_id'));
        $question = Question::where('slug', $slug)->where('type', 'assignment')->first();

        //Check of vraag bestaat
        if(!$question) return view('error')->with(compact('team'))->with('msg', 'Ongeldige code, vraag niet gevonden.');

        //Check of er al een antwoord is, anders redirecten
        $answer = QuestionTeam::where('question_id', $question->id)->where('team_id', $team->id)->first();
        if(!$answer) return redirect('/qr/' . $question->slug);

        //Check of vraag voor dit team nog niet is afgelopen 
        if($answer->finished_at != null) return redirect('/qr/' . $question->slug);
        
        $answer->finished_at = \Carbon\Carbon::now();
        $answer->save();

        return view('assignment2')->with(compact('question'))->with(compact('team'));
    }

    public function question(Request $request, $slug, $answer_given)
    {
        $team = Team::find($request->session()->get('team_id'));
        $question = Question::where('slug', $slug)->where('type', 'question')->first();

        //Check of vraag bestaat
        if(!$question) return view('error')->with(compact('team'))->with('msg', 'Ongeldige code, vraag niet gevonden.');

        //Check of er al een antwoord is, anders redirecten
        $answer = QuestionTeam::where('question_id', $question->id)->where('team_id', $team->id)->first();
        if(!$answer) return redirect('/qr/' . $question->slug);

        //Check of vraag voor dit team nog niet is afgelopen 
        if($answer->finished_at != null) return redirect('/qr/' . $question->slug);
        
        $answer->answer_given = $answer_given;
        $answer->points = (strcasecmp($answer_given, $question->correct_answer) == 0) ? 2 : 0;
        $answer->finished_at = \Carbon\Carbon::now();
        $answer->save();

        return view('question2')->with(compact('answer'))->with(compact('team'))->with(compact('question'));
    }
}
