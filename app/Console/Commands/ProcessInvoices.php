<?php

namespace Sv\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Sv\Invoice;
use Sv\Jobs\PayInvoice;

class ProcessInvoices extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sv:process-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes pending invoices for the day';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // @todo: timezone should come from user's company in the future
        $invoices = Invoice::whereIn('status', ['pending', 'overdue'])->where('num_tries', '<=', 3)->whereDate('try_on_date', '<=', Carbon::today(env('TIMEZONE'))->toDateString())->get();
        if ($invoices->count() > 0) {
            foreach ($invoices as $invoice) {
                $this->dispatch(new PayInvoice($invoice));
            }

            $this->info('Invoices Processed!');
        }
    }
}
