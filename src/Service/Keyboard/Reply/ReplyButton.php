<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Service\Keyboard\Reply;

class ReplyButton
{
    public function __construct(private string $text)
    {
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
