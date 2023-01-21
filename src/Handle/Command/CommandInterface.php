<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Handle\Command;

use TelegramBot\Api\Types\Update;
use Evmv\TelegramBot\Handle\GeneralInterface;

interface CommandInterface extends GeneralInterface
{
    public function __invoke(Update $update): void;
}
