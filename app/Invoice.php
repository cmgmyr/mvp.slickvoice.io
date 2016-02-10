<?php

namespace Sv;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
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
        'uuid', 'public_id', 'client_id', 'due_date', 'try_on_date', 'num_tries', 'status', 'repeat', 'charge_id', 'charge_date', 'charge_fee',
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
     * Get all of the invoice's logs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function logs()
    {
        return $this->morphMany('Sv\Log', 'logable')->latest();
    }

    /**
     * Returns the latest formatted log.
     *
     * @return string
     */
    public function latestLog()
    {
        return $this->logs()->first()->render();
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

    /**
     * Returns the totals for all possible invoice statuses.
     *
     * @return array
     */
    public static function getTotalsByStatuses()
    {
        $totals = [];
        $result = DB::select(DB::raw("SHOW COLUMNS FROM `invoices` LIKE 'status'"));
        if ($result) {
            $statuses = explode("','", preg_replace("/(enum|set)\('(.+?)'\)/", '\\2', $result[0]->Type));

            foreach ($statuses as $status) {
                $totals[$status] = self::getTotalsByStatus($status);
            }
        }

        return $totals;
    }

    /**
     * Returns the total of the given status.
     *
     * @return string
     */
    public static function getTotalsByStatus($status)
    {
        $invoices = DB::table('invoices')
            ->select(DB::raw('SUM(invoice_items.price) as total'))
            ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
            ->where('invoices.status', $status)
            ->first();

        return number_format($invoices->total, 2);
    }

    /**
     * Sees if $_GET['status'] is available, and add it to the query.
     *
     * @param $query
     * @return mixed
     */
    public function scopeRequestStatus($query)
    {
        if (request('status', false)) {
            $query->where('status', request('status'));
        }

        return $query;
    }
}
