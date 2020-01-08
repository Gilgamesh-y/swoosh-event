<?php

namespace Src\Event;

class EventManager
{
    /**
     * Binding listeners for events
     *
     * @param mixed $event
     * @param string|Closure $listener
     * @param bool $is_coroutine
     */
    public function listen($event, $listen, $is_coroutine = false)
    {
        if ($is_coroutine) {
            $this->makeListener($event, $listen);
        } else {
            go(function () use ($event, $listen) {
                $this->makeListener($event, $listen);
            });
        }
    }

    /**
     * Binding class listeners for events
     *
     * @param string $event
     */
    public function makeClassListener($event)
    {
        $listeners = $event->listeners;
        
        foreach ($listeners as $listen) {
            empty($event->is_coroutine) ? (new $listen)->handle($event) : go(function () use ($listen, $event) {
                (new $listen)->handle($event);
            });
        }
    }

    /**
     * Binding listeners for events
     *
     * @param mixed $event
     * @param string|Closure $listener
     */
    public function makeListener($event, $listen)
    {
        is_string($listen) ? (new $listen)->handle($event) : $listen();
    }
}