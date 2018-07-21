<?php

namespace App\Http\Controllers;

use App\Events\UserConnected;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $league;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->league = new LeagueController();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recuperou = false;
        if (empty(Auth::user()->league_id)) {
            $league = $this->league->getUserId(Auth::user()->name);
            if ($league["status"] == LeagueController::RESULTADO_OK) {
                $recuperou = true;
            }
        }
        broadcast(new UserConnected(Auth::user()));
        return view('home', ['recuperou' => $recuperou]);
    }
}
