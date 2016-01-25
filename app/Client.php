<?php

namespace Sv;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stripe_id', 'email', 'name', 'card_last_four', 'card_exp_month', 'card_exp_year', 'card_brand', 'address', 'address2', 'city', 'state', 'zip', 'phone',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'stripe_id',
    ];

    /**
     * Returns a CC brand class used in Font Awesome.
     *
     * @return string
     */
    public function getCardBrandClassAttribute()
    {
        if($this->card_brand == 'American Express') {
            return 'cc-amex';
        }

        if ($this->card_brand == 'MasterCard') {
            return 'cc-mastercard';
        }

        if ($this->card_brand == 'Visa') {
            return 'cc-visa';
        }

        return 'cc-stripe';
    }
}
