<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Service\Keyboard\Inline;

class InlineButton
{
    private string $text;
    private ?string $onClick = null;
    private array $arguments = [];

    public function __construct(string $text)
    {
        $this->text = $text;
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

    public function getOnClick(): string
    {
        return $this->onClick;
    }

    public function setOnClick(?string $onClickAction): self
    {
        $this->onClick = $onClickAction;

        return $this;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function setArguments(array $arguments): self
    {
        $this->arguments = $arguments;

        return $this;
    }
}
