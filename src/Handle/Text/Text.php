<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Handle\Text;

#[\Attribute]
class Text
{
    public function __construct(public readonly string $text)
    {
    }
}