<?php

namespace App\Http\Controllers;

use App\Events\UserConnected;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Pusher;

class HomeController extends Controller
{
    private $league, $pusher;
    const DEFAULT_CHANNEL_NAME = 'presence-queue.';
    const DEFAULT_ICON_LOL_URL = 'http://ddragon.leagueoflegends.com/cdn/8.14.1/img/profileicon/';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->league = new LeagueController();

        try {
            $this->pusher = new Pusher\Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                array( 'cluster' => env('PUSHER_APP_CLUSTER'), 'encrypted' => true ));
        } catch (\Exception $exp) {
            var_dump($exp);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recuperou = false;
        if (empty(Auth::user()->league_profileiconid) || empty(Auth::user()->league_summonerlevel)) {
            $league = $this->league->getUserId(Auth::user()->league_name);
            if ($league["status"] == LeagueController::RESULTADO_OK) {
                $recuperou = true;
            }
        }
        broadcast(new UserConnected(Auth::user()));
        return view('home', ['recuperou' => $recuperou]);
    }

    public function retrieveUserChannels() {
        $return = array (
            "canais"    => [],
            "status"    => 0
        );
        try {
            $result = $this->pusher->get_channels(array('filter_by_prefix' => 'presence-queue.'));
            $channelNames = array_keys($result->channels);
            $canais = array();
            foreach ($channelNames as $name) {
                $idOwner = substr($name, strlen(self::DEFAULT_CHANNEL_NAME), strlen($name));
                $userOwner = User::find($idOwner);
                if (isset($userOwner)) {
                    $info = $this->pusher->get('/channels/' . $name . '/users');
                    $qntUsers = sizeof($info['result']['users']);
                    $icones = array();
                    foreach ($info['result']['users'] as $usuario) {
                        $usuarioAux = User::find($usuario['id']);
                        $icones[] = self::DEFAULT_ICON_LOL_URL . $usuarioAux->league_profileiconid . ".png";
                    }
                    $canais[] = array(
                        'name' => $userOwner->name,
                        'users' => $qntUsers,
                        'desc' => "Partida de " . $userOwner->name,
                        'link' => 'match/' . $idOwner,
                        'images' => $icones
                    );
                }
            }
            if (sizeof($canais) > 0) {
                $return["status"] = 200;
                $return["canais"] = $canais;
            } else {
                $return["status"] = 100;
            }
        } catch (\Exception $e) {
            // notihing
            $return["error"] = $e->getMessage();
            $return["stack"] = $e->getTraceAsString();
            $return["file"]  = $e->getFile();
            $return["line"]  = $e->getLine();
        }
        return $return;
    }
}
