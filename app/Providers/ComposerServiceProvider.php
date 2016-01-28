<?php

namespace Sv\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // all views
        view()->composer('*', 'Sv\Http\Composers\AppComposer');

        // invoice views
        view()->composer('invoices.*', 'Sv\Http\Composers\InvoiceComposer');
    }
}
