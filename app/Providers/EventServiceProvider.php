<?php

namespace Sv\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Sv\Events\InvoiceWasPaid' => [
            'Sv\Listeners\SendClientPaidInvoice',
            'Sv\Listeners\SendAdminsPaidInvoice',
        ],
        'Sv\Events\InvoiceWasNotPaid' => [
            'Sv\Listeners\SendClientNotPaidInvoice',
            'Sv\Listeners\SendAdminsNotPaidInvoice',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
