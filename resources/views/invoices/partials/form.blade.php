<div class="row">
    <div class="col-md-4">
        <!-- Client Form Input -->
        <div class="form-group">
            {{ Form::label('client_id', 'Client', ['class' => 'control-label']) }}
            {!! Form::select('client_id', $clients, $invoice->client_id, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="col-md-4">
        <!-- Due Date Form Input -->
        <div class="form-group">
            {{ Form::label('due_date', 'Due Date', ['class' => 'control-label']) }}
            {{ Form::date('due_date', $invoice->due_date, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group text-right">
            <label for="total" class="control-label">Total</label>
            <p class="form-control-static">$<span id="invoice-total">{{ number_format($invoice->items->sum('price'), 2) }}</span></p>
        </div>
    </div>
</div>
<hr>

<div class="row">
    <div id="invoice-items" class="col-md-10 col-md-push-1">
        <h2>Invoice Items</h2>
        <div id="invoice-items-sortable">
            @if(isset($items) && count($items) > 0)
                @foreach($items as $item)
                    @include('invoices.partials.invoice-item-editable', ['item' => $item])
                @endforeach
            @elseif($invoice->items->count() > 0)
                @foreach($invoice->items as $item)
                    @include('invoices.partials.invoice-item-editable', ['item' => $item->toArray()])
                @endforeach
            @else
                @include('invoices.partials.invoice-item-editable', ['item' => []])
            @endif
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <a href="#" class="btn btn-success invoice-item-add"><span class="fa fa-plus"></span> Add Invoice Item</a>
            </div>
        </div>
    </div>
</div>

<hr>
<!-- Save Form Input -->
<div class="form-group">
    <button class="btn btn-lg btn-primary" type="submit">Save</button>
</div>

@section('scripts')
    <script type="text/javascript">
        $(function () {
            $('#invoice-items-sortable').sortable({ opacity: 0.6});

            $(document).on('click', '.invoice-item-add', function () {
                return addInvoiceItem();
            });

            $(document).on('keydown', '.invoice-item-price:last', function (e) {
                if (e.which == 9) {
                    return addInvoiceItem();
                }
            });

            $(document).on('click', '.invoice-item-delete', function () {
                if ($('#invoice-items-sortable > .row').length > 1) {
                    $(this).closest('.row').remove();
                    updateTotal();
                }
                return false;
            });

            $(document).on('change', '.invoice-item-price', function () {
                updateTotal();
            });
        });

        function addInvoiceItem() {
            $.get('/invoices/items/create', function (data) {
                $('#invoice-items-sortable').append(data);
                $('.invoice-item-description').last().focus();
            });

            return false;
        }

        function updateTotal() {
            var total = 0, price = 0;

            $('input.invoice-item-price').each(function() {
                price = parseFloat($(this).val());
                if (isNaN(price)) {
                    price = 0;
                }

                total += price;
                $(this).val(price.toFixed(2));
            });

            $('#invoice-total').html(total.toFixed(2));

            return total;
        }
    </script>
@stop
