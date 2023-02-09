<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\OurExampleEventBarbara;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OurExampleListenerBarbara
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
     * @param  \App\Events\OurExampleEventBarbara  $event
     * @return void
     */
    public function handle(OurExampleEventBarbara $event)
    {
        //import log, lets check the event
        Log::debug("The user {$event->username} just performed {$event->action}");
    }
}
