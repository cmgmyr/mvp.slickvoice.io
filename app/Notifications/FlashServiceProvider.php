<?php

namespace Sv\Notifications;

use Illuminate\Support\ServiceProvider;

class FlashServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('flash', function () {
            return $this->app->make('Sv\Notifications\FlashNotifier');
        });
    }
}
