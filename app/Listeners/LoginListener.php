<?php

namespace App\Listeners;

use App\Events\LoginEvent;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoginListener
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
     * @param  object  $event
     * @return void
     */
    public function handle()
    {
        // store data
//        $time = Carbon::now()->toDateTimeString();
//        $username = $event->username;
//        $email = $event->email;
//        DB:table('user_login_his')->insert([
//            'name' => $username,
//            'email' => $email,
//            'created_at' => $time,
//            'updated_at' => $time
//        ]);
    }
}
