<?php

namespace Sv\Jobs;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Stripe\Charge as StripeCharge;
use Sv\Events\InvoiceWasPaid;
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
                'amount' => $total,
                'currency' => 'usd',
                'customer' => $stripe_id,
                'description' => 'SlickVoice Invoice ID: ' . $this->invoice->public_id,
            ]);

            $this->invoice->status = 'paid';
            $this->invoice->charge_id = $charge->id;
            $this->invoice->charge_date = Carbon::today();
            $this->invoice->save();

            $this->dispatch(new AddInvoiceFee($this->invoice, $charge->balance_transaction));
            event(new InvoiceWasPaid($this->invoice));

            if ($this->invoice->repeat != 'no') {
                // duplicate the invoice
                $this->dispatch(new DuplicateInvoice($this->invoice, $this->invoice->repeat));

                // turn off repeating on paid invoice
                $this->invoice->repeat = 'no';
                $this->invoice->save();
            }
        } catch (Exception $e) {
            Log::error('Invoice #' . $this->invoice->id . ' did not process: (' . $e->getCode() . ') - ' . $e->getMessage());
            $this->tryAgain();
        }
    }

    /**
     * Set the invoice to overdue and try again tomorrow.
     */
    protected function tryAgain()
    {
        $this->invoice->status = 'overdue';
        if ($this->invoice->num_tries >= 3) {
            $this->invoice->status = 'error';
        }

        $this->invoice->try_on_date = Carbon::tomorrow();
        $this->invoice->increment('num_tries');
        $this->invoice->save();
    }
}
