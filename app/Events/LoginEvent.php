<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Auth\Events\Login;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;

class LoginEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
//    public $username;
//    public $email;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->username = $username;
//        $this->email = $email;
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        try {
            $user = $event->user;
            $user_id = $user->id;
            $nik = $user->nik_gsd;
            $name = $user->name;
            $email = $user->email;
            $user_ip = request()->getClientIp();

            $userAgent = osBrowser();
            $browser = @$userAgent['browser'];
            $os = @$userAgent['os_platform'];

            if ($position = Location::get($user_ip)) {
                $longtitude = $position->longitude;
                $latitude = $position->latitude;
                $location = $position->cityName;
                $country = $position->countryName;
                $country_code = $position->countryCode;
            } else {
                $longtitude = null;
                $latitude = null;
                $location = null;
                $country = null;
                $country_code = null;
            }

            $created_at = Carbon::now()->toDateTimeString();
            $updated_at = Carbon::now()->toDateTimeString();

            DB::table('user_login_his')->insert([
                'user_id' => $user_id,
                'nik' => $nik,
                'name' => $name,
                'email' => $email,
                'user_ip' => $user_ip,
                'browser' => $browser,
                'os' => $os,
                'longtitude' => $longtitude,
                'latitude' => $latitude,
                'location' => $location,
                'country' => $country,
                'country_code' => $country_code,
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);
        } catch (\Throwable $th) {
            report($th);
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
