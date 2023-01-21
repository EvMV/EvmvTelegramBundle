<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Handle\Upload\UploadContact;

use TelegramBot\Api\Types\Update;
use Evmv\TelegramBot\Handle\GeneralInterface;

interface ContactInterface extends GeneralInterface
{
    public function __invoke(Update $update): void;
}
