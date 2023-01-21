<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Handle\Command;

#[\Attribute]
class Command
{
    public function __construct(public readonly string $command)
    {
    }
}
