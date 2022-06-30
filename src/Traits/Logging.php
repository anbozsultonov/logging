<?php

namespace Model\Logging\Traits;

use Model\Logging\Observers\LogObserver;

trait Logging
{
    public static function bootLogging(): void
    {
        static::observe(LogObserver::class);
    }
}