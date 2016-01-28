<div class="row">
    <div class="col-md-1">
        <div class="form-group">
            <p class="form-control-static"><span class="fa fa-navicon"></span></p>
        </div>
    </div>
    <div class="col-md-7">
        <div class="form-group">
            <input type="text" name="description[]" placeholder="Description" class="invoice-item-description form-control" value="{{ array_get($item, 'description', null) }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" name="price[]" placeholder="0.00" class="invoice-item-price form-control" value="{{ array_get($item, 'price', null) }}">
            </div>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <p class="form-control-static"><a href="#" class="btn btn-danger btn-xs invoice-item-delete"><span class="fa fa-trash"></span></a></p>
        </div>
    </div>
</div>
