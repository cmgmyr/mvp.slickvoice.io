<!-- Card Number Form Input -->
<div class="form-group">
    <label for="card_number" class="control-label">Card Number</label>
    <input type="text" id="card_number" name="card_number" class="form-control" value="{{ old('card_number') }}" data-stripe="number" maxlength="20">
</div>

<div class="row">
    <div class="col-md-4">
        <!-- CSV Form Input -->
        <div class="form-group">
            <label for="csv" class="control-label">CSV</label>
            <input type="text" id="csv" name="csv" class="form-control" value="{{ old('csv') }}" data-stripe="cvc" maxlength="4">
        </div>
    </div>

    <div class="col-md-4">
        <!-- Exp Month Form Input -->
        <div class="form-group">
            <label for="exp_month" class="control-label">Exp Month</label>
            <input type="text" id="exp_month" name="exp_month" class="form-control" value="{{ old('exp_month') }}" data-stripe="exp-month" maxlength="2" placeholder="XX">
        </div>
    </div>

    <div class="col-md-4">
        <!-- Exp Year Form Input -->
        <div class="form-group">
            <label for="exp_year" class="control-label">Exp Year</label>
            <input type="text" id="exp_year" name="exp_year" class="form-control" value="{{ old('exp_year') }}" data-stripe="exp-year" maxlength="4" placeholder="XXXX">
        </div>
    </div>
</div>

@section('scripts')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
        Stripe.setPublishableKey('{{ config('services.stripe.key') }}');

        $(function () {
            $('.credit-form').submit(function(event) {
                var $form = $(this);

                // Disable the submit button to prevent repeated clicks
                $form.find('button').prop('disabled', true);

                Stripe.card.createToken($form, stripeResponseHandler);

                // Prevent the form from submitting with the default action
                return false;
            });
        });

        function stripeResponseHandler(status, response) {
            var $form = $('.credit-form');

            if (response.error) {
                // Show the errors on the form
                alert(response.error.message);
                $form.find('button').prop('disabled', false);
            } else {
                // response contains id and card, which contains additional card details
                var token = response.id;
                // Insert the token into the form so it gets submitted to the server
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                // and submit
                $form.get(0).submit();
            }
        }
    </script>
@stop
