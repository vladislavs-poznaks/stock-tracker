<?php

namespace App\Listeners;

use App\Events\NowAvailable;
use App\Models\Stock;
use App\Models\User;
use App\Notifications\ImportantStockUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendStockUpdateNotification
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
     * @param  NowAvailable  $event
     * @return void
     */
    public function handle(NowAvailable $event)
    {
        User::first()->notify(new ImportantStockUpdate($event->stock));
    }
}
