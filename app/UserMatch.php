<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMatch extends Model
{
    protected $table = 'users_matches';

    public function user()
    {
        return $this->belongsTo('App\User', 'league_id', 'league_id');
    }
}
