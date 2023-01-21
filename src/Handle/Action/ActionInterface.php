<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Handle\Action;

use TelegramBot\Api\Types\Update;
use Evmv\TelegramBot\Handle\GeneralInterface;

interface ActionInterface extends GeneralInterface
{
    public function __invoke(Update $update): void;
}
