<?php

namespace App;

use App\Http\Controllers\LeagueController;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatusSemanal;

class User extends Authenticatable
{
    use Notifiable;
    const BASE_URL = 'https://br1.api.riotgames.com/lol';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'league_id', 'league_accountid', 'league_name', 'league_profileiconid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function canJoinRoom($queueId) {
        return true;
    }

    public function retrieveRank() {

        $url = self::BASE_URL . "/league/v3/positions/by-summoner/" . $this->league_id;
        $headers = ['headers' => [
            'Origin' => env('APP_URL'),
            'Accept-Charset' => 'application/x-www-form-urlencoded; charset=UTF-8',
            "Accept-Language" => "pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7",
            'X-Riot-Token' => User::apikey()
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

    public function ranks()
    {
        return $this->hasMany('App\UserRank', 'league_id', 'league_id');
    }

    public function getWinLosses() {
        $wins = $loss = 0;
        $rank = User::find($this->id)->ranks->all();
        if (sizeof($rank) != 0) {
            $wins = $rank[0]['wins'];
            $loss = $rank[0]['losses'];
        }
        return array("wins" => $wins, "losses" => $loss);
    }

    private static function apikey() {
        return env('LEAGUE_KEY');
    }

    public function sendStatus() {
        $resposta = $this->getWinLosses();
        Mail::to($this)->send(new StatusSemanal($resposta));
    }

}
