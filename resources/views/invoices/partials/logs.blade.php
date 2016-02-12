@if($invoice->logs->count())
    <div class="row">
        <div id="invoice-items" class="col-md-8 col-md-push-2">
            <h2>Invoice Logs</h2>
            <div>
                @foreach($invoice->logs as $log)
                    <div class="row">
                        <div class="col-md-12">
                            {{ $log->render() }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
