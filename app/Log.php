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
        'level', 'body',
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
            'level' => 'error',
            'body' => '(' . $e->getCode() . ') ' . $e->getMessage(),
        ]);

        $model->logs()->save($log);

        return $log;
    }

    /**
     * Creates a new log for the specified model from a string.
     *
     * @param $message
     * @param Model $model
     * @param string $level
     * @return Log
     */
    public static function createFromMessage($message, Model $model, $level = 'info')
    {
        $log = self::create([
            'level' => $level,
            'body' => $message,
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
        return '[' . $this->created_at->tz(env('TIMEZONE'))->format('m/d/Y @ g:i:s a T') . '] ' . $this->level . ': ' . $this->body;
    }
}
