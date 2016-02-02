<?php

namespace Sv\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Stripe\BalanceTransaction as StripeTransaction;
use Sv\Invoice;

class AddInvoiceFee extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var Invoice
     */
    protected $invoice;

    /**
     * @var
     */
    protected $transactionId;

    /**
     * Create a new job instance.
     *
     * @param Invoice $invoice
     * @param $transactionId
     */
    public function __construct(Invoice $invoice, $transactionId)
    {
        $this->invoice = $invoice;
        $this->transactionId = $transactionId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $transaction = StripeTransaction::retrieve($this->transactionId);
        $this->invoice->charge_fee = $transaction->fee / 100; // stripe comes back as cents, not dollars
        $this->invoice->save();
    }
}
