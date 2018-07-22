<?php

namespace App\Listeners;

use App\Events\MatchCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMatchCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MatchCreated  $event
     * @return void
     */
    public function handle(MatchCreated $event)
    {
        //
    }
}
