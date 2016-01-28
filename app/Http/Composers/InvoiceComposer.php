<?php

namespace Sv\Http\Composers;

use Illuminate\Contracts\View\View;

class InvoiceComposer
{
    protected $view;

    /**
     * Pushes custom data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $this->view = $view;

        $this->getInvoiceRepeatOptions();
    }

    protected function getInvoiceRepeatOptions()
    {
        $this->view->with('invoiceRepeatOptions', [
            'no' => 'No',
            'month' => 'Monthly',
            'year' => 'Yearly',
        ]);
    }
}
