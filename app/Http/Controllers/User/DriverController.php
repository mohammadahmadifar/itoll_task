<?php

namespace App\Http\Controllers\User;

use App\Events\UpdateLocationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LocationRequest;

class DriverController extends Controller
{
    /**
     * @param LocationRequest $request
     * @return void
     */
    public function sendLocation(LocationRequest $request): void
    {
        event(new UpdateLocationEvent($request->validated()));
    }
}
