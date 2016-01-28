<?php

namespace Sv\Traits;

use Webpatser\Uuid\Uuid;

trait UuidModelTrait
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        /**
         * Attach to the 'creating' Model Event to provide a UUID.
         */
        static::creating(function ($model) {
            $model->uuid = (string)$model->generateNewUuid();
        });
    }

    /**
     * Get a new version 4 (random) UUID.
     *
     * @return Uuid
     */
    public function generateNewUuid()
    {
        return Uuid::generate(4);
    }
}
