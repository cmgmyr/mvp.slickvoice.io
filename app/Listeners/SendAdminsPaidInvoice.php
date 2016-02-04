<?php

namespace Sv\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Sv\Events\InvoiceWasPaid;
use Sv\User;

class SendAdminsPaidInvoice implements ShouldQueue
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
        $alert = 'Payment Made!';
        $users = User::all();

        foreach ($users as $user) {
            Mail::queue('emails.invoice', compact('invoice', 'alert'), function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('A Payment Has Been Made!');
            });
        }
    }
}
