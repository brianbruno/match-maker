<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 22/07/2018
 * Time: 15:31
 */

namespace App\Http\Controllers;


use App\Notifications\SalaCriada;
use Illuminate\Support\Facades\Auth;

class MatchController extends Controller {
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
     * Show the match screen.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index($match_id) {
        $user = Auth::user();
        $user->notify(new SalaCriada($user));
        return view('match', ["match_id" => $match_id]);
    }

}
