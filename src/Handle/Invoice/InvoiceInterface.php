<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Handle\Invoice;

use TelegramBot\Api\Types\Update;
use Evmv\TelegramBot\Handle\GeneralInterface;

interface InvoiceInterface extends GeneralInterface
{
    public function __invoke(Update $update): void;
}
