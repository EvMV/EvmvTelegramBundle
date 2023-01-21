<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Handle\Action;

#[\Attribute]
class Action
{
    public function __construct(public readonly string $action)
    {
    }
}
