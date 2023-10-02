<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Handle\Middleware\Local;

use TelegramBot\Api\Types\Update;
use Evmv\TelegramBot\Handle\GeneralInterface;

interface MiddlewareInterface extends GeneralInterface
{
    public function middleware(Update $update): bool;
}
