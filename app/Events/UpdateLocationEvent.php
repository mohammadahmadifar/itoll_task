<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateLocationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->res = $request;
    }

}
