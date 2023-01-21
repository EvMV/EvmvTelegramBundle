<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Handle\Upload\UploadVoice;

use TelegramBot\Api\Types\Update;
use Evmv\TelegramBot\Handle\GeneralInterface;

interface UploadVoiceInterface extends GeneralInterface
{
    public function __invoke(Update $update): void;
}
