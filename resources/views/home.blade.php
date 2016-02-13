@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h2>Total Sales</h2>
            <div id="sales"></div>
        </div>
        <div class="col-md-4">
            <h2>{{ date('F') }} Invoices</h2>
            <div id="invoice_pie"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
        (function ($) {
            if ($('#sales').length)
                new Morris.Bar({
                    element: 'sales',
                    data: [
                        { y: 'Apr 15', a: 100 },
                        { y: 'May 15', a: 75 },
                        { y: 'Jun 15', a: 50 },
                        { y: 'Jul 15', a: 75 },
                        { y: 'Aug 15', a: 50 },
                        { y: 'Sep 15', a: 75 },
                        { y: 'Oct 15', a: 100 },
                        { y: 'Nov 15', a: 200 },
                        { y: 'Dec 15', a: 300 },
                        { y: 'Jan 16', a: 260 },
                        { y: 'Feb 16', a: 40}
                    ],
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Sales'],
                    barColors: ['#039BE5'],
                    barShape: 'soft',
                    xLabelMargin: 10,
                    resize: true
                });

            if ($('#invoice_pie').length)
                new Morris.Donut({
                    element: 'invoice_pie',
                    data: [
                        { label: "Pending", value: 12 },
                        { label: "Overdue", value: 3 },
                        { label: "Paid", value: 20 }
                    ],
                    colors: ['#039BE5', '#FF5722', '#4CAF50'],
                    resize: true
                });
        }(jQuery));
    </script>
@stop
