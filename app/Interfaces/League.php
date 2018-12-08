<?php

namespace App\Interfaces;

use App\Http\Controllers\Controller;
use App\UserMatch;
use App\UserRank;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class League extends Controller
{

    const BASE_URL = 'https://br1.api.riotgames.com/lol';
    const RESULTADO_NEUT = "0";
    const RESULTADO_OK   = "1";
    const RESULTADO_FAIL = "2";
    const TAXA_POR_MILISSEGUNDO = 0.05;
    private static $ultimaRequisicao;

    public function __construct() {
        League::$ultimaRequisicao = self::getAtualMilissegundos();
    }


    private function consultarAPI($url) {
        $headers = ['headers' => [
            'Origin' => League::url(),
            'Accept-Charset' => 'application/x-www-form-urlencoded; charset=UTF-8',
            "Accept-Language" => "pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7",
            'X-Riot-Token' => League::apikey()
        ]
        ];
        $client = new Client();
        try {
            if (League::getAutorizacao()) {
                $response = $client->request('GET', $url, $headers);
                League::$ultimaRequisicao = self::getAtualMilissegundos();
                if ($response->getStatusCode() == 200) {
                    $response = json_decode($response->getBody()->getContents());
                }
            }
        } catch (\Exception $e) {
            $response = array("status" => array(
                "message" => $e->getMessage(),
                "status_code" => $e->getCode()
            ));
        }
        return $response;
    }

    public function atualizarPartidas($user) {

        $accountid = $user->league_accountid;

        $response = null;
        $url = self::BASE_URL . "/match/v3/matchlists/by-account/" . $accountid . "?queue=420";
        $matches = $this->consultarAPI($url);

        foreach ($matches->matches as $match) {

            $partida = UserMatch::where('gameId', '=', $match->gameId)
                        ->where('league_id', '=', $user->league_id)->first();

            if (empty($partida)) {
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

    public function atualizarRanks($user) {
        $url = self::BASE_URL . "/league/v3/positions/by-summoner/".$user->league_id;
        $ranks = $this->consultarAPI($url);

        foreach ($ranks as $rank) {
            $elo = UserRank::where("league_id", "=", $user->league_id)
                ->where("queueType", "=", $rank->queueType)->first();

            if (empty($elo)) {
                $novoRank = new UserRank();
                $novoRank->league_id = $user->league_id;
                $novoRank->leagueName = $rank->leagueName;
                $novoRank->tier = $rank->tier;
                $novoRank->rank = $rank->rank;
                $novoRank->leaguePoints = $rank->leaguePoints;
                $novoRank->wins = $rank->wins;
                $novoRank->losses = $rank->losses;
                $novoRank->queueType = $rank->queueType;
                $novoRank->save();
            } else {
                $elo->leagueName = $rank->leagueName;
                $elo->tier = $rank->tier;
                $elo->rank = $rank->rank;
                $elo->leaguePoints = $rank->leaguePoints;
                $elo->wins = $rank->wins;
                $elo->losses = $rank->losses;

                $elo->save();
            }
        }
    }

    public function atualizarPerfil($user) {
        $url = self::BASE_URL . "/summoner/v3/summoners/by-account/" . $user->league_accountid;
        $perfil = $this->consultarAPI($url);

        $user->league_summonerlevel = $perfil->summonerLevel;
        $user->league_profileiconid = $perfil->profileIconId;
        $user->league_name = $perfil->name;

        $user->save();
    }

    private static function apikey() {
        return env('LEAGUE_KEY');
    }

    private static function url() {
        return env('APP_URL');
    }

    private static function getAutorizacao() {
        // Funcao criada para nao permitir que o sistema ultrapasse o limite da API.
        $momento = self::getAtualMilissegundos();
        $diferenca = $momento - self::$ultimaRequisicao;
        if (floatval($diferenca) < self::TAXA_POR_MILISSEGUNDO) {
            sleep(0.5);
        }
        return true;
    }

    private static function getAtualMilissegundos() {
        return round(microtime(true) * 1000);
    }


}
