<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Service\Keyboard\Inline;

use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use Evmv\TelegramBot\Handle\Action\Action;
use Evmv\TelegramBot\Helper\ClassHelper\ClassHelper;

class InlineKeyboardGenerator
{
    /** @var InlineButton[] */
    private array $buttons = [];

    public function __construct(private readonly ClassHelper $classHelper)
    {
    }

    public function getButtons(): array
    {
        return $this->buttons;
    }

    public function button(string $text, string $onClick = '', array $arguments = []): self
    {
        $inlineButton = new InlineButton($text);
        $inlineButton->setArguments($arguments);

        if (class_exists($onClick)) {
            $actionAttribute = $this->classHelper->getClassAttribute($onClick, Action::class);
            if (empty($actionAttribute['action'])) {
                throw new \Exception(sprintf('Class %s without attribute Action', $onClick));
            }

            $inlineButton->setOnClick($actionAttribute['action']);
        } else {
            $inlineButton->setOnClick($onClick);
        }

        $this->buttons[] = $inlineButton;

        return $this;
    }

    public function br(): self
    {
        $this->buttons[] = null;

        return $this;
    }

    public function generateKeyboard(): InlineKeyboardMarkup
    {
        $this->br();
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

            $row[] = ['text' => $button->getText(), 'callback_data' => json_encode(['_ac' => $button->getOnClick(), ...$button->getArguments()])];
        }

        return new InlineKeyboardMarkup($buttonArray);
    }
}
