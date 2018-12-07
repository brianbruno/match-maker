<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 06/12/2018
 * Time: 21:45
 */

namespace App\Http\Controllers;


use App\Interfaces\League;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller {

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
    public static function index() {
        return view('user.perfil', ['user' => Auth::user()]);
    }

}