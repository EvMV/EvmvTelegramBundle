<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Handle;

use Evmv\TelegramBot\Handle\Action\ActionInterface;
use Evmv\TelegramBot\Handle\Any\AnyInterface;
use Evmv\TelegramBot\Handle\Command\CommandInterface;
use Evmv\TelegramBot\Handle\Invoice\InvoiceInterface;
use Evmv\TelegramBot\Handle\Location\LocationInterface;
use Evmv\TelegramBot\Handle\Middleware\Global\GlobalMiddlewareInterface;
use Evmv\TelegramBot\Handle\Middleware\Local\MiddlewareInterface;
use Evmv\TelegramBot\Handle\Text\TextInterface;
use Evmv\TelegramBot\Handle\Upload\UploadAudio\UploadAudioInterface;
use Evmv\TelegramBot\Handle\Upload\UploadContact\ContactInterface;
use Evmv\TelegramBot\Handle\Upload\UploadDocument\UploadDocumentInterface;
use Evmv\TelegramBot\Handle\Upload\UploadPhoto\UploadPhotoInterface;
use Evmv\TelegramBot\Handle\Upload\UploadVideo\UploadVideoInterface;
use Evmv\TelegramBot\Handle\Upload\UploadVoice\UploadVoiceInterface;

enum HandleEnum: string
{
    case CommandInterface = CommandInterface::class;
    case ActionInterface = ActionInterface::class;
    case TextInterface = TextInterface::class;

    case UploadPhotoInterface = UploadPhotoInterface::class;
    case UploadDocumentInterface = UploadDocumentInterface::class;
    case UploadVideoInterface = UploadVideoInterface::class;
    case UploadAudioInterface = UploadAudioInterface::class;
    case ContactInterface = ContactInterface::class;
    case UploadVoiceInterface = UploadVoiceInterface::class;

    case InvoiceInterface = InvoiceInterface::class;

    case LocationInterface = LocationInterface::class;

    case AnyInterface = AnyInterface::class;

    case MiddlewareInterface = MiddlewareInterface::class;
    case GlobalMiddlewareInterface = GlobalMiddlewareInterface::class;
}
