<?php

namespace Sv\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Stripe\Charge as StripeCharge;
use Stripe\Error\Card as CardDeclined;
use Sv\Invoice;

class PayInvoice extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs;

    /**
     * @var Invoice
     */
    protected $invoice;

    /**
     * Create a new job instance.
     *
     * @param Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stripe_id = $this->invoice->client->stripe_id;
        $total = $this->invoice->items->sum('price') * 100; // stripe uses cents instead of dollars

        try {
            $charge = StripeCharge::create([
                "amount" => $total,
                "currency" => "usd",
                "customer" => $stripe_id,
                "description" => "SlickVoice Invoice ID: " . $this->invoice->id,
            ]);

            $this->invoice->status = 'paid';
            $this->invoice->charge_id = $charge->id;
            $this->invoice->save();

            if ($this->invoice->repeat != 'no') {
                // duplicate the invoice
                $this->dispatch(new DuplicateInvoice($this->invoice));

                // turn off repeating on paid invoice
                $this->invoice->repeat = 'no';
                $this->invoice->save();
            }
        } catch (CardDeclined $e) {
            $this->tryAgain();
        }
    }

    /**
     * Set the invoice to overdue and try again tomorrow.
     */
    protected function tryAgain()
    {
        $this->invoice->status = 'overdue';
        $this->invoice->due_date = $this->invoice->due_date->addDay();
        $this->invoice->save();
    }
}
