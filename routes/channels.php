<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('matchs', function ($user) {
    return ['name' => $user->name.' Match'];
});

Broadcast::channel('queue.{queueId}', function ($user, $queueId) {
    $league = new \App\Http\Controllers\LeagueController();
    if ($user->canJoinRoom($queueId)) {
        $rank = $league->getRank();
        $winloss = $user->getWinLosses();
        $icone = "http://ddragon.leagueoflegends.com/cdn/8.14.1/img/profileicon/".$user->league_profileiconid.".png";
        return ['id' => $user->id, 'name' => $user->league_name, 'icone' => $icone,'rank' => $rank,
                'wins' => $winloss["wins"], 'losses' => $winloss["losses"]];
    }
});
