<?php

namespace App\Listeners;

use App\Models\User\Driver;
use Illuminate\Support\Facades\Auth;
use MatanYadaev\EloquentSpatial\Objects\Point;

class UpdateLocationListener
{

    /**
     * @param $event
     * @return void
     */
    public function handle($event): void
    {
        $user = Auth::user()->id;
        Driver::updateOrCreate(
            ['user_id' => $user],
            ['location' => new Point($event->res['longitude'], $event->res['latitude']), 'user_id' => $user]
        );
    }
}
