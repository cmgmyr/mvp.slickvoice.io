<?php

namespace Sv\Notifications;

use Illuminate\Session\Store;

class FlashNotifier
{
    /**
     * @var \Illuminate\Session\Store
     */
    protected $session;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Sets a successful flash message.
     *
     * @param $message
     */
    public function success($message)
    {
        $this->message($message, 'success');
    }

    /**
     * Sets an error flash message.
     *
     * @param $message
     */
    public function error($message)
    {
        $this->message($message, 'danger');
    }

    /**
     * Sets a given message and level.
     *
     * @param $message
     * @param string $level
     */
    public function message($message, $level = 'info')
    {
        $this->session->flash('flash_notification.message', $message);
        $this->session->flash('flash_notification.level', $level);
    }
}
