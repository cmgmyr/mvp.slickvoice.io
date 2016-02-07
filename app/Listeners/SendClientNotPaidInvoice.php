<?php

namespace Sv\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Sv\Events\InvoiceWasNotPaid;

class SendClientNotPaidInvoice implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  InvoiceWasNotPaid  $event
     * @return void
     */
    public function handle(InvoiceWasNotPaid $event)
    {
        $invoice = $event->invoice;
        $alert = 'Payment error, action required!';
        $log = false;

        Mail::queue('emails.invoice-declined', compact('invoice', 'alert', 'log'), function ($m) use ($invoice) {
            $m->to($invoice->client->email, $invoice->client->name)->subject('Payment error, action required!');
        });
    }
}
