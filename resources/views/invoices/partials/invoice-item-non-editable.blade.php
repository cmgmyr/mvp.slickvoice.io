<div class="row">
    <div class="col-md-9">
        <div class="form-group">
            <p class="form-control-static">{{ array_get($item, 'description') }}</p>
        </div>
    </div>
    <div class="col-md-3 text-right">
        <div class="form-group">
            <div class="input-group">
                <p class="form-control-static">${{ number_format(array_get($item, 'price'), 2) }}</p>
            </div>
        </div>
    </div>
</div>
