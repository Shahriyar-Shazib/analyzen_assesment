<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserAddressSaved;
use Illuminate\Support\Facades\Log;

class SaveUserAddresses
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserAddressSaved $event): void
    {
        $address = $event->address;
        $user = $event->user;
        // dd($user, $address);
        // exit;
        $user->addresses()->create(['address' => $address]);
       
    }
}
