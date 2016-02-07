<?php

namespace Sv\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Sv\Events\InvoiceWasNotPaid;
use Sv\User;

class SendAdminsNotPaidInvoice implements ShouldQueue
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
        $alert = 'Payment Error!';
        $log = $event->invoice->latestLog();
        $users = User::all();

        foreach ($users as $user) {
            Mail::queue('emails.invoice-declined', compact('invoice', 'alert', 'log'), function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('Payment Error!');
            });
        }
    }
}
