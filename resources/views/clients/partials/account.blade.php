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
    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $client->phone) }}">
</div>
