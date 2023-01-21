<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Core;

use Evmv\TelegramBot\Helper\Process\TelegramProcessHelper;
use TelegramBot\Api\Types\Update;
use Evmv\TelegramBot\Handle\Action\Action;
use Evmv\TelegramBot\Handle\Command\Command;
use Evmv\TelegramBot\Handle\GeneralInterface;
use Evmv\TelegramBot\Handle\HandleEnum;
use Evmv\TelegramBot\Handle\Middleware\Local\Middleware;
use Evmv\TelegramBot\Handle\Text\Text;
use Evmv\TelegramBot\Helper\ClassHelper\ClassHelper;
use Evmv\TelegramBot\Helper\Update\Update as UpdateWrapper;

class Core
{
    private Update $update;

    public function __construct(
        private readonly ClassHelper $classHelper,
        private readonly TelegramProcessHelper $telegramProcessHelper,
        UpdateWrapper $update,
    ) {
        $this->update = $update->getUpdate();
    }

    public function command(): void
    {
        if (!$this->checkerCommand()) {
            return;
        }

        $commandMessageFromUpdate = $this->update->getMessage()->getText();
        $commandMessageFromUpdate = str_replace('/', '', $commandMessageFromUpdate);

        $commandList = $this->classHelper->getClassesByInterface(HandleEnum::CommandInterface);

        foreach ($commandList as $command) {
            $commandAttribute = $this->classHelper->getClassAttribute($command::class, Command::class);
            if (empty($commandAttribute)) {
                continue;
            }

            $commandText = str_replace('/', '', $commandAttribute['command']);

            if ($this->currentCommand($commandText, $commandMessageFromUpdate, $command::class)) {
                if (!$this->middlewarePass($command)) {
                    return;
                }

                $command->__invoke($this->update);

                break;
            }
        }
    }

    public function action(): void
    {
        if (!$this->checkerAction()) {
            return;
        }

        $actionList = $this->classHelper->getClassesByInterface(HandleEnum::ActionInterface);

        $callback = $this->update->getCallbackQuery();
        $data = json_decode($callback->getData(), true);

        foreach ($actionList as $action) {
            $classAttribute = $this->classHelper->getClassAttribute($action::class, Action::class);
            $actionName = $classAttribute['action'];

            if ($data['_ac'] === $actionName) {
                if (!$this->middlewarePass($action)) {
                    continue;
                }

                $action->__invoke($this->update);

                break;
            }
        }
    }

    public function text(): void
    {
        if (!$this->checkerText()) {
            return;
        }

        $textList = $this->classHelper->getClassesByInterface(HandleEnum::TextInterface);

        $message = $this->update->getMessage()->getText();

        foreach ($textList as $text) {
            $classAttribute = $this->classHelper->getClassAttribute($text::class, Text::class);
            $textCaption = $classAttribute['text'];

            if ($message === $textCaption) {
                if (!$this->middlewarePass($text)) {
                    continue;
                }

                $text->__invoke($this->update);

                break;
            }
        }
    }

    public function any(): void
    {
        $anyList = $this->classHelper->getClassesByInterface(HandleEnum::AnyInterface);

        foreach ($anyList as $any) {
            if (!$this->middlewarePass($any)) {
                continue;
            }

            $any->__invoke($this->update);
        }
    }

    public function uploadPhoto(): void
    {
        if (!$this->checkerUploadPhoto()) {
            return;
        }

        $uploadPhotoList = $this->classHelper->getClassesByInterface(HandleEnum::UploadPhotoInterface);

        foreach ($uploadPhotoList as $uploadPhoto) {
            if (!$this->middlewarePass($uploadPhoto)) {
                continue;
            }

            $uploadPhoto->__invoke($this->update);
        }
    }

    public function uploadDocument(): void
    {
        if (!$this->checkerUploadDocument()) {
            return;
        }

        $uploadDocumentList = $this->classHelper->getClassesByInterface(HandleEnum::UploadDocumentInterface);

        foreach ($uploadDocumentList as $uploadDocument) {
            if (!$this->middlewarePass($uploadDocument)) {
                continue;
            }

            $uploadDocument->__invoke($this->update);
        }
    }

    public function uploadVideo(): void
    {
        if (!$this->checkerUploadVideo()) {
            return;
        }

        $uploadVideoList = $this->classHelper->getClassesByInterface(HandleEnum::UploadVideoInterface);

        foreach ($uploadVideoList as $uploadVideo) {
            if (!$this->middlewarePass($uploadVideo)) {
                continue;
            }

            $uploadVideo->__invoke($this->update);
        }
    }

    public function uploadAudio(): void
    {
        if (!$this->checkerUploadAudio()) {
            return;
        }

        $uploadAudioList = $this->classHelper->getClassesByInterface(HandleEnum::UploadAudioInterface);

        foreach ($uploadAudioList as $uploadAudio) {
            if (!$this->middlewarePass($uploadAudio)) {
                continue;
            }

            $uploadAudio->__invoke($this->update);
        }
    }

    public function uploadContact(): void
    {
        if (!$this->checkerUploadContact()) {
            return;
        }

        $uploadContactList = $this->classHelper->getClassesByInterface(HandleEnum::ContactInterface);

        foreach ($uploadContactList as $uploadContact) {
            if (!$this->middlewarePass($uploadContact)) {
                continue;
            }

            $uploadContact->__invoke($this->update);
        }
    }

    public function uploadVoice(): void
    {
        if (!$this->checkerUploadVoice()) {
            return;
        }

        $uploadVoiceList = $this->classHelper->getClassesByInterface(HandleEnum::UploadVoiceInterface);

        foreach ($uploadVoiceList as $uploadVoice) {
            if (!$this->middlewarePass($uploadVoice)) {
                continue;
            }

            $uploadVoice->__invoke($this->update);
        }
    }

    public function invoice(): void
    {
        if (!$this->checkerInvoice()) {
            return;
        }

        $uploadInvoiceList = $this->classHelper->getClassesByInterface(HandleEnum::InvoiceInterface);

        foreach ($uploadInvoiceList as $uploadInvoice) {
            if (!$this->middlewarePass($uploadInvoice)) {
                continue;
            }

            $uploadInvoice->__invoke($this->update);
        }
    }

    public function location(): void
    {
        if (!$this->checkerLocation()) {
            return;
        }

        $locationList = $this->classHelper->getClassesByInterface(HandleEnum::LocationInterface);

        foreach ($locationList as $location) {
            if (!$this->middlewarePass($location)) {
                continue;
            }

            $location->__invoke($this->update);
        }
    }

    public function middleware(): bool
    {
        $middlewaresList = $this->classHelper->getClassesByInterface(HandleEnum::GlobalMiddlewareInterface);

        foreach ($middlewaresList as $middleware) {
            if (!$this->middlewarePass($middleware)) {
                return false;
            }

            if (!$middleware->middleware($this->update)) {
                return false;
            }
        }

        return true;
    }

    private function middlewarePass(GeneralInterface $handle): bool
    {

        $middlewaresList = $this->classHelper->getClassesByInterface(HandleEnum::MiddlewareInterface);
        $handleMiddlewares = $this->classHelper->getClassAttributes($handle::class, Middleware::class);

        $handleMiddlewareClass = [];
        foreach ($handleMiddlewares as $handleMiddleware) {
            $handleMiddlewareClass[] = $handleMiddleware->getArguments()['class'];
        }

        if (0 === count($handleMiddlewareClass)) {
            return true;
        }

        foreach ($middlewaresList as $middleware) {
            if (!in_array($middleware::class, $handleMiddlewareClass)){
                continue;
            }

            if (!$middleware->middleware($this->update)) {
                return false;
            }

            if (!$this->middlewarePass($middleware)) {
                return false;
            }
        }

        return true;
    }

    private function checkerCommand(): bool
    {
        $message = $this->update->getMessage();
        if (!$message) {
            return false;
        }

        $text = $message->getText();
        if (!$text || '/' !== $text[0]) {
            return false;
        }

        return true;
    }

    private function currentCommand(string $command, string $commandFromUpdate, string $class): bool
    {
        $queryParams = $this->telegramProcessHelper->commandQuery($this->update, $class) ?? [];

        if ((!$queryParams || !$queryParams[array_key_first($queryParams)]) && str_contains($command, '{')) {
            return false;
        }

        foreach ($queryParams as $queryParamName => $queryParamValue) {
            $command = str_replace(sprintf('{%s}', $queryParamName), '', $command);
            $commandFromUpdate = str_replace($queryParamValue, '', $commandFromUpdate);
        }

        if (strcmp($command, $commandFromUpdate) !== 0) {
            return false;
        }

        return true;
    }

    private function checkerAction(): bool
    {
        $callback = $this->update->getCallbackQuery();
        if (is_null($callback) || !strlen($callback->getData())) {
            return false;
        }

        return true;
    }

    private function checkerText(): bool
    {
        if ($this->checkerAction() || $this->checkerCommand()) {
            return false;
        }

        $message = $this->update->getMessage();
        if (!$message) {
            return false;
        }

        $text = $message->getText();
        if (!$text || '/' !== $text[0]) {
            return false;
        }

        return true;
    }

    private function checkerUploadPhoto(): bool
    {
        $message = $this->update->getMessage();
        if (!$message) {
            return false;
        }

        if (!$message->getPhoto()) {
            return false;
        }

        return true;
    }

    private function checkerUploadDocument(): bool
    {
        $message = $this->update->getMessage();
        if (!$message) {
            return false;
        }

        if (!$message->getDocument()) {
            return false;
        }

        return true;
    }

    private function checkerUploadVideo(): bool
    {
        $message = $this->update->getMessage();
        if (!$message) {
            return false;
        }

        if (!$message->getVideo()) {
            return false;
        }

        return true;
    }

    private function checkerUploadAudio(): bool
    {
        $message = $this->update->getMessage();
        if (!$message) {
            return false;
        }

        if (!$message->getAudio()) {
            return false;
        }

        return true;
    }

    private function checkerUploadContact(): bool
    {
        $message = $this->update->getMessage();
        if (!$message) {
            return false;
        }

        if (!$message->getContact()) {
            return false;
        }

        return true;
    }

    private function checkerUploadVoice(): bool
    {
        $message = $this->update->getMessage();
        if (!$message) {
            return false;
        }

        if (!$message->getVoice()) {
            return false;
        }

        return true;
    }

    private function checkerInvoice(): bool
    {
        $message = $this->update->getMessage();
        if (!$message) {
            return false;
        }

        if (!$message->getInvoice()) {
            return false;
        }

        return true;
    }

    private function checkerLocation(): bool
    {
        $message = $this->update->getMessage();
        if (!$message) {
            return false;
        }

        if (!$message->getLocation()) {
            return false;
        }

        return true;
    }
}
