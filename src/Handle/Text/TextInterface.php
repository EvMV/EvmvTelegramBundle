<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Handle\Text;

use TelegramBot\Api\Types\Update;
use Evmv\TelegramBot\Handle\GeneralInterface;

interface TextInterface extends GeneralInterface
{
    public function __invoke(Update $update): void;
}
