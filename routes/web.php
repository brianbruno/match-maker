<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/perfil', 'PerfilController@index')->name('perfil');

Route::get('/match/{match_id}', function ($match_id) {
    if (!empty( \App\User::find($match_id) )) {
        return \App\Http\Controllers\MatchController::index($match_id);
    } else {
        abort(440);
    }
})->where('match_id', '[0-9]+')->name('match');

Route::get('/getchannels', function() {
    $home = new \App\Http\Controllers\HomeController;
    $result = $home->retrieveUserChannels();
    return $result;
});

Route::get('/matchinfo', 'MatchInfoController@index')->name('matchinfo')->middleware('auth');

Route::post('/matchinfo', 'MatchInfoController@checkUsername')->name('checkgames')->middleware('auth');
