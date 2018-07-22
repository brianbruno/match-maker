<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 21/07/2018
 * Time: 16:01
 */

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class LeagueController extends Controller
{

    const BASE_URL = 'https://br1.api.riotgames.com/lol';
    const RESULTADO_NEUT = "0";
    const RESULTADO_OK   = "1";
    const RESULTADO_FAIL = "2";


    public function __construct()
    {
        //
    }

    public function getUserId($name) {

        $user = Auth::user();

        $retorno = array(
            "status" => self::RESULTADO_NEUT
        );

        $userInfo = $this->getUserInfo($name);

        if ($userInfo != null) {
            $user->league_id            = $userInfo->id;
            $user->league_accountid     = $userInfo->accountId;
            $user->league_name          = $userInfo->name;
            $user->league_profileiconid = $userInfo->profileIconId;
            $user->league_summonerlevel = $userInfo->summonerLevel;

            $user->save();
            $retorno["status"] = self::RESULTADO_OK;
        } else {
            $retorno["status"] = self::RESULTADO_FAIL;
        }

        return $retorno;
    }

    public function getUserInfo($name)
    {
        $response = null;
        $url = self::BASE_URL . "/summoner/v3/summoners/by-name/" . $name;
        $headers = ['headers' => [
                'Origin' => 'http://match.maker',
                'Accept-Charset' => 'application/x-www-form-urlencoded; charset=UTF-8',
                "Accept-Language" => "pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7",
                'X-Riot-Token' => LeagueController::apikey()
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

    public function getRank() {
        $response = null;
        $user = Auth::user();
        $url = self::BASE_URL . "/league/v3/positions/by-summoner/" . $user->league_id;
        $headers = ['headers' => [
            'Origin' => 'http://match.maker',
            'Accept-Charset' => 'application/x-www-form-urlencoded; charset=UTF-8',
            "Accept-Language" => "pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7",
            'X-Riot-Token' => LeagueController::apikey()
        ]
        ];
        $client = new Client();

        try {
            $response = $client->request('GET', $url, $headers);

            if ($response->getStatusCode() == 200) {
                $response = json_decode($response->getBody()->getContents());
                if(sizeof($response) > 0) {
                    $response = $response[0]->tier." ".$response[0]->rank;
                }
            }
        } catch (\Exception $e) {
            $response = null;
        }

        return $response;
    }

    private static function apikey() {
        return env('LEAGUE_KEY');
    }


}
