<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Handle\Any;

use TelegramBot\Api\Types\Update;
use Evmv\TelegramBot\Handle\GeneralInterface;

interface AnyInterface extends GeneralInterface
{
    public function __invoke(Update $update): void;
}
