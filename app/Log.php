<?php

namespace Sv;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'message',
    ];

    /**
     * Polymorphic relationships.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function logable()
    {
        return $this->morphTo();
    }

    /**
     * Creates a new log for the specified model from an Exception.
     *
     * @param Exception $e
     * @param Model $model
     * @return Log
     */
    public static function createFromException(Exception $e, Model $model)
    {
        $log = self::create([
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
        ]);

        $model->logs()->save($log);

        return $log;
    }

    /**
     * Returns the formatted log data.
     *
     * @return string
     */
    public function render()
    {
        return $this->created_at->tz(env('TIMEZONE'))->format('m/d/Y @ g:i:s a T') . ': (' . $this->code . ') ' . $this->message;
    }
}
