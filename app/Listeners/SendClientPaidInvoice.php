<?php

namespace Sv\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Sv\Events\InvoiceWasPaid;

class SendClientPaidInvoice implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  InvoiceWasPaid  $event
     * @return void
     */
    public function handle(InvoiceWasPaid $event)
    {
        $invoice = $event->invoice;
        $alert = 'Thank You for Your Payment!';

        Mail::queue('emails.invoice', compact('invoice', 'alert'), function ($m) use ($invoice) {
            $m->to($invoice->client->email, $invoice->client->name)->subject('Your Payment Receipt!');
        });
    }
}
