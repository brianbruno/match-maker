<?php

namespace App\Interfaces;

use App\Http\Controllers\Controller;
use App\UserMatch;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class League extends Controller
{

    const BASE_URL = 'https://br1.api.riotgames.com/lol';
    const RESULTADO_NEUT = "0";
    const RESULTADO_OK   = "1";
    const RESULTADO_FAIL = "2";

    public function consultarAPI($url) {
        $headers = ['headers' => [
            'Origin' => 'http://match.maker',
            'Accept-Charset' => 'application/x-www-form-urlencoded; charset=UTF-8',
            "Accept-Language" => "pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7",
            'X-Riot-Token' => League::apikey()
        ]
        ];
        $client = new Client();
        try {
            $response = $client->request('GET', $url, $headers);
            if ($response->getStatusCode() == 200) {
                $response = json_decode($response->getBody()->getContents());
            }
        } catch (\Exception $e) {
            $response = null;
        }
        return $response;
    }

    public function atualizarPartidas($user) {

        $accountid = $user->league_accountid;

        $response = null;
        $url = self::BASE_URL . "/match/v3/matchlists/by-account/" . $accountid . "?queue=420";
        $matches = $this->consultarAPI($url);

        foreach ($matches->matches as $match) {

            $partida = UserMatch::where('gameId', '=', $match->gameId)->get();

            if (!empty($partida)) {
                $newMatch = new UserMatch();

                $newMatch->league_id = $user->league_id;
                $newMatch->platformId = $match->platformId;
                $newMatch->gameId = $match->gameId;
                $newMatch->champion = $match->champion;
                $newMatch->queue = $match->queue;
                $newMatch->season = $match->season;
                $newMatch->timestamp = $match->timestamp;
                $newMatch->role = $match->role;
                $newMatch->lane = $match->lane;

                $newMatch->save();
            }

        }

    }

    private static function apikey() {
        return env('LEAGUE_KEY');
    }

    private static function url() {
        return env('APP_URL');
    }


}
