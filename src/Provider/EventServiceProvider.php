<?php

namespace Src\Event\Provider;

use Src\Core\AbstractProvider;
use Src\Event\EventManager;

class EventServiceProvider extends AbstractProvider
{
    public function register()
    {
        $this->app->set('event', function () {
            return new EventManager($this->app);
        });
    }
}