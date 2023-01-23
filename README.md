## About 
Bundle uses attributes to describe function telegrams.
It will allow you to write flexible telegram bot systems.

## Install 
Require the bundle and its dependencies with composer:
```bash
$ composer require evmv/telegram-bundle
```

Register the bundle:
```php
// config/bundles.php
return [
    Evmv\TelegramBot\TelegramBundle::class => ['all' => true]
];
```

And add your bot key to .env:
```dotenv
BOT_KEY=your_telegram_bot_key
```

## Usage ##

### Command:
To create a command handler, create a class that implements the interface:
```php
Evmv\TelegramBot\Handle\Command\CommandInterface
```

And describe the command in the attribute
```php
Evmv\TelegramBot\Handle\Command\Command
```

Example:
```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Evmv\TelegramBot\Handle\Command\Command;
use Evmv\TelegramBot\Handle\Command\CommandInterface;
use TelegramBot\Api\Types\Update;

#[Command(command: '/start')]
class StartCommand implements CommandInterface
{
    public function __construct() 
    {
    }

    public function __invoke(Update $update): void
    {
        // Do something
    }
}

```
You can also use command options by specifying the command as:
```php
#[Command(command: '/start{param}')]
```

And then get this parameter using
```php
Evmv\TelegramBot\Helper\Process\TelegramProcessHelper
```

Example:
```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Evmv\TelegramBot\Handle\Command\Command;
use Evmv\TelegramBot\Handle\Command\CommandInterface;
use Evmv\TelegramBot\Helper\Process\TelegramProcessHelper;
use TelegramBot\Api\Types\Update;

#[Command(command: '/start{param}')]
class StartCommand implements CommandInterface
{
    public function __construct(
        private readonly TelegramProcessHelper $processHelper
    ) {
    }

    public function __invoke(Update $update): void
    {
        $data = $this->processHelper->commandQuery($update, self::class);
        // $data = ['param' => value]
    }
}

```

### Handle inline keyboard button click:
To create reply markup, use the service:
```php
Evmv\TelegramBot\Service\Keyboard\Reply\ReplyKeyboardGenerator
```

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

To handle the button click, create a class that implements the interface:
```php
Evmv\TelegramBot\Handle\Action\ActionInterface
```

And annotate it:
```php
Evmv\TelegramBot\Handle\Action\Action;
```

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
To create reply markup, use the service:
```php
Evmv\TelegramBot\Service\Keyboard\Reply\ReplyKeyboardGenerator
```

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

### Text
To process incoming text, use a class that implements the interface:
```php
Evmv\TelegramBot\Handle\Text\TextInterface
```
And also the attribute that describes the text:
```php
Evmv\TelegramBot\Handle\Text\Text
```

Example:
```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Evmv\TelegramBot\Handle\Command\CommandInterface;
use Evmv\TelegramBot\Handle\Text\Text;
use TelegramBot\Api\Types\Update;

#[Text(text: 'Hello world')]
class TextProcess implements CommandInterface
{
    public function __construct() {
    }

    public function __invoke(Update $update): void
    {
        // Do something
    }
}

```

### Middleware:
You can also add a query processing filter. For this, use Middleware:
```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Evmv\TelegramBot\Handle\Command\CommandInterface;
use Evmv\TelegramBot\Handle\Middleware\Local\Middleware;
use Evmv\TelegramBot\Handle\Text\Text;
use TelegramBot\Api\Types\Update;

#[Text(text: 'Buy cat')]
#[Middleware(class: UserHaveEnoughMoney::class)]
class TextProcess implements CommandInterface
{
    public function __construct() {
    }

    public function __invoke(Update $update): void
    {
        // Do something
    }
}

```

The handler class must implement the interface:
```php
Evmv\TelegramBot\Handle\Middleware\Local\MiddlewareInterface
```

Example:
```php
<?php

namespace App\Controller;

use Evmv\TelegramBot\Handle\Middleware\Local\MiddlewareInterface;
use TelegramBot\Api\Types\Update;

class UserHaveEnoughMoney implements MiddlewareInterface
{
    public function middleware(Update &$update): bool
    {
        // Some filter
    }
}
```

### GlobalMiddleware:safasfsdf

### Use complete event:
Bundle releases the following events:
+ Invoice
+ Location
+ Text
+ Upload:
  + UploadAudio
  + UploadContact
  + UploadDocument
  + UploadPhoto
  + UploadVideo
  + UploadVoice

Special event: 
+ Any

To use them, create a class that implements their interface and describes the attribute.

### Create own event:
If you need to create a function that will be called on an event that is not listed above, use the Any event with Middleware.
Example:
```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Evmv\TelegramBot\Handle\Any\Any;
use Evmv\TelegramBot\Handle\Any\AnyInterface;
use Evmv\TelegramBot\Handle\Middleware\Local\Middleware;
use TelegramBot\Api\Types\Update;

#[Any]
#[Middleware(class: ReplyToMessage::class)]
class TextProcess implements AnyInterface
{
    public function __construct() {
    }

    public function __invoke(Update $update): void
    {
        // Do something
    }
}

```

### How To Contribute
To contribute just open a Pull Request with your new code taking into account that if you add new features or modify existing ones you have to document in this README what they do. If you break BC then you have to document it as well.