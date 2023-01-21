<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Handle\Upload\UploadAudio;

use TelegramBot\Api\Types\Update;
use Evmv\TelegramBot\Handle\GeneralInterface;

interface UploadAudioInterface extends GeneralInterface
{
    public function __invoke(Update $update): void;
}
