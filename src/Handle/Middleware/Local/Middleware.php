<?php

namespace Evmv\TelegramBot\Handle\Middleware\Local;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS)]
class Middleware
{
    public function __construct(public readonly string $class)
    {
    }
}