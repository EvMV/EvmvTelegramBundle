### Handle inline keyboard button click:
To create inline markup, use the service [ReplyKeyboardGenerator](https://github.com/EvMV/EvmvTelegramBundle/src/Service/Keyboard/Reply/ReplyKeyboardGenerator.php).

Example:
```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Evmv\TelegramBot\Handle\Command\Command;
use Evmv\TelegramBot\Handle\Command\CommandInterface;
use Evmv\TelegramBot\Service\Keyboard\Inline\InlineKeyboardGenerator;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Update;

#[Command(command: '/start')]
class StartCommand implements CommandInterface
{
    public function __construct(
        private readonly InlineKeyboardGenerator $generator,
        private readonly BotApi $client
    ) {
    }

    public function __invoke(Update $update): void
    {
        $chat = $update->getMessage()->getChat();

        $keyboard = $this->generator
            ->button('First row first button', ButtonClick::class, ['item' => 1])
            ->button('Second row second button', ButtonClick::class, ['item' => 2])
            ->br()
            ->button('Second row first button', ButtonClick::class, ['item' => 3])
            ->generateKeyboard();

        $this->client->sendMessage($chat->getId(), 'Hello. Click to button', replyMarkup: $keyboard);
    }
}

```

To handle the button click, create a class that implements the interface [ActionInterface](https://github.com/EvMV/EvmvTelegramBundle/src/Handle/Action/ActionInterface.php).

And annotate it using [Action](https://github.com/EvMV/EvmvTelegramBundle/src/Handle/Action/Action.php).

Example:
```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Evmv\TelegramBot\Handle\Action\Action;
use Evmv\TelegramBot\Handle\Action\ActionInterface;
use Evmv\TelegramBot\Helper\Process\TelegramProcessHelper;
use TelegramBot\Api\Types\Update;

#[Action(action: 'click')]
class ButtonClick implements ActionInterface
{
    public function __construct(private readonly TelegramProcessHelper $processHelper)
    {
    }

    public function __invoke(Update $update): void
    {
        $data = $this->processHelper->callbackQueryPayload($update);
        // Do something
    }
}

```

### Handle reply keyboard button click:
To create reply markup, use the service [ReplyKeyboardGenerator](https://github.com/EvMV/EvmvTelegramBundle/src/Service/Keyboard/Reply/ReplyKeyboardGenerator.php).

Example:
```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Evmv\TelegramBot\Handle\Command\Command;
use Evmv\TelegramBot\Handle\Command\CommandInterface;
use Evmv\TelegramBot\Service\Keyboard\Reply\ReplyKeyboardGenerator;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Update;

#[Command(command: '/start')]
class StartCommand implements CommandInterface
{
    public function __construct(
        private readonly ReplyKeyboardGenerator $generator,
        private readonly BotApi $client
    ) {
    }

    public function __invoke(Update $update): void
    {
        $chat = $update->getMessage()->getChat();

        $keyboard = $this->generator
            ->button('First row first button')
            ->button('Second row first button')
            ->br()
            ->button('Second row first button')
            ->generateKeyboard();

        $this->client->sendMessage($chat->getId(), 'Hello. Click to button', replyMarkup: $keyboard);
    }
}


```