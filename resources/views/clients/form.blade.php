<div class="col-md-6">
    <div class="form-group">
        <h3>Client Information</h3>
    </div>

    <!-- Stripe ID Form Input -->
    <div class="form-group">
        <label for="stripe_id" class="control-label">Stripe ID</label>
        <input type="text" id="stripe_id" name="stripe_id" class="form-control" value="{{ $client->stripe_id }}" readonly>
    </div>

    <!-- Name Form Input -->
    <div class="form-group">
        <label for="name" class="control-label">Name</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $client->name) }}">
    </div>

    <!-- Email Form Input -->
    <div class="form-group">
        <label for="email" class="control-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $client->email) }}">
    </div>

    <!-- Address Form Input -->
    <div class="form-group">
        <label for="address" class="control-label">Address</label>
        <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $client->address) }}">
    </div>

    <!-- Address 2 Form Input -->
    <div class="form-group">
        <label for="address2" class="control-label">Address 2</label>
        <input type="text" id="address2" name="address2" class="form-control" value="{{ old('address2', $client->address2) }}">
    </div>

    <!-- City Form Input -->
    <div class="form-group">
        <label for="city" class="control-label">City</label>
        <input type="text" id="city" name="city" class="form-control" value="{{ old('city', $client->city) }}">
    </div>

    <!-- State Form Input -->
    <div class="form-group">
        <label for="state" class="control-label">State</label>
        <input type="text" id="state" name="state" class="form-control" value="{{ old('state', $client->state) }}">
    </div>

    <!-- Zip Form Input -->
    <div class="form-group">
        <label for="zip" class="control-label">Zip</label>
        <input type="text" id="zip" name="zip" class="form-control" value="{{ old('zip', $client->zip) }}">
    </div>

    <!-- Phone Form Input -->
    <div class="form-group">
        <label for="phone" class="control-label">Phone</label>
        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <h3>Default Credit Card</h3>
    </div>

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

    <!-- Save Form Input -->
    <div class="form-group">
        <button class="btn btn-lg btn-primary" type="submit">Save</button>
    </div>
</div>

@section('scripts')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
        Stripe.setPublishableKey('{{ config('services.stripe.key') }}');

        $(function () {
            $('#client-form').submit(function(event) {
                var $form = $(this);

                // Disable the submit button to prevent repeated clicks
                $form.find('button').prop('disabled', true);

                Stripe.card.createToken($form, stripeResponseHandler);

                // Prevent the form from submitting with the default action
                return false;
            });
        });

        function stripeResponseHandler(status, response) {
            var $form = $('#client-form');

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
