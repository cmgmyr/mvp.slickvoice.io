<?php

namespace Sv;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sv\Traits\UuidModelTrait;

class Invoice extends Model
{
    use UuidModelTrait, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'public_id', 'client_id', 'due_date', 'try_on_date', 'num_tries', 'status', 'repeat', 'charge_id', 'charge_date',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'due_date', 'try_on_date', 'charge_date',
    ];

    /**
     * Invoice belongs to a client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Invoice has many items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Generates the next public invoice number.
     *
     * @return int
     */
    public static function getNextPublicId()
    {
        $max = self::withTrashed()->max('public_id');

        return $max >= 1000 ? ++$max : 1000;
    }
}
