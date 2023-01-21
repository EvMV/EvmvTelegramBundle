<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Handle\Event;

#[\Attribute]
class Event
{
    public function __construct(public readonly string $class)
    {
    }
}
