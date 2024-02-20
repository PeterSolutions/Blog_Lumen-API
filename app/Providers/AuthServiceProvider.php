<?php

namespace App\Providers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

use Dusterio\LumenPassport\LumenPassport;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        LumenPassport::routes($this->app);
        // $client_id = '1';
        // LumenPassport::tokensExpireIn(Carbon::now()->addDays(14), $client_id); 

    /* rest of boot */ 
    $this->app['auth']->viaRequest('api', function ($request) {
    if ($request->input('api_token')) {
        return User::where('api_token', $request->input('api_token'))->first();
        }
     });           
     
    }
}