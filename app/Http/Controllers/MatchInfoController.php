<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 04/08/2018
 * Time: 12:16
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class MatchInfoController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the match screen.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index() {
        return view('matchinfo');
    }

    public function checkUsername(Request $request) {
        $username = $request->input('username');
        $qtPartidasJogadasJunto = 0;
        $leagueInfo = new LeagueController();

        $partidas = $leagueInfo->getMatches(null)->matches;
        $qtdPartidas = sizeof($partidas);
        $i = 0;
        while ($i < 20 && $i < $qtdPartidas) {
            $match = $leagueInfo->getMatches($partidas[$i]->gameId);
            foreach ($match->participantIdentities as $player) {
                if ($player->player->summonerName == $username) {
                    $qtPartidasJogadasJunto++;
                }
            }
            $i++;
        }
        return view('matchinfo', ['partidas' => $qtPartidasJogadasJunto, 'username' => $username]);
    }

}
