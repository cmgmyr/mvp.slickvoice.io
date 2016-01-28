<?php

namespace Sv;

use Illuminate\Database\Eloquent\Model;
use Sv\Traits\UuidModelTrait;

class InvoiceItem extends Model
{
    use UuidModelTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoice_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'invoice_id', 'description', 'price', 'sort',
    ];

    /**
     * Invoice items belong to an invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
