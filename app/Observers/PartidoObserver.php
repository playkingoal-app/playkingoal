<?php

namespace App\Observers;

use App\Models\Partido;

class PartidoObserver
{
    /**
     * Handle the Partido "created" event.
     *
     * @param  \App\Models\Partido  $partido
     * @return void
     */
    public function created(Partido $partido)
    {
        //
    }

    /**
     * Handle the Partido "updated" event.
     *
     * @param  \App\Models\Partido  $partido
     * @return void
     */
    public function updated(Partido $partido)
{
    // Solo si cambió el estado a FT
    if ($partido->estado === 'FT') {
        \App\Jobs\SyncResultsJob::dispatch()->onQueue('high');
    }
}


    /**
     * Handle the Partido "deleted" event.
     *
     * @param  \App\Models\Partido  $partido
     * @return void
     */
    public function deleted(Partido $partido)
    {
        //
    }

    /**
     * Handle the Partido "restored" event.
     *
     * @param  \App\Models\Partido  $partido
     * @return void
     */
    public function restored(Partido $partido)
    {
        //
    }

    /**
     * Handle the Partido "force deleted" event.
     *
     * @param  \App\Models\Partido  $partido
     * @return void
     */
    public function forceDeleted(Partido $partido)
    {
        //
    }
}
