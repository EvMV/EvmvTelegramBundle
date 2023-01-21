<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Service\Keyboard\Reply;

use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class ReplyKeyboardGenerator
{
    /** @var ReplyButton[] */
    private array $buttons = [];

    private bool $resizeButton = false;
    private bool $oneTimeKeyboard = false;
    private bool $selective = false;

    public function getButtons(): array
    {
        return $this->buttons;
    }

    public function getResizeButton(): bool
    {
        return $this->resizeButton;
    }

    public function setResizeButton(bool $resizeButton): self
    {
        $this->resizeButton = $resizeButton;

        return $this;
    }

    public function getOneTimeKeyboard(): bool
    {
        return $this->oneTimeKeyboard;
    }

    public function setOneTimeKeyboard(bool $oneTimeKeyboard): self
    {
        $this->oneTimeKeyboard = $oneTimeKeyboard;

        return $this;
    }

    public function getSelective(): bool
    {
        return $this->selective;
    }

    public function setSelective(bool $selective): self
    {
        $this->selective = $selective;

        return $this;
    }

    public function button(string $text): self
    {
        $replyButton = new ReplyButton($text);
        $this->buttons[] = $replyButton;

        return $this;
    }

    public function br(): self
    {
        $this->buttons[] = null;

        return $this;
    }

    public function generateKeyboard(): ReplyKeyboardMarkup
    {
        $buttonArray = [];
        $row = [];
        foreach ($this->buttons as $button) {
            if (!$button) {
                if (0 < count($row)) {
                    $buttonArray[] = $row;
                    $row = [];
                }

                continue;
            }

            $row[] = ['text' => $button->getText()];
        }

        return new ReplyKeyboardMarkup($buttonArray, $this->oneTimeKeyboard, $this->resizeButton, $this->selective);
    }
}
