<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Handle\Middleware\Global;

use TelegramBot\Api\Types\Update;
use Evmv\TelegramBot\Handle\GeneralInterface;

interface GlobalMiddlewareInterface extends GeneralInterface
{
    public function middleware(Update &$update): bool;
}
