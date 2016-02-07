<?php

namespace Sv\Events;

use Illuminate\Queue\SerializesModels;
use Sv\Invoice;

class InvoiceWasNotPaid extends Event
{
    use SerializesModels;

    /**
     * @var Invoice
     */
    public $invoice;

    /**
     * Create a new event instance.
     *
     * @param Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }
}
