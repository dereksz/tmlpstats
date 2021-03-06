<?php namespace TmlpStats\Handlers\Events;

use Log;
use Request;

use TmlpStats\User;
use Carbon\Carbon;

class AuthLoginEventHandler
{

    /**
     * Create the event handler.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  User $user
     */
    public function handle(User $user)
    {
        $user->lastLoginAt = Carbon::now();
        $user->save();

        Log::info("User {$user->id} logged in from " . Request::ip());
    }
}
