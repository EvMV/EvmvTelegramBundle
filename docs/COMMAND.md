### Command:
To create a command handler, create a class that implements [CommandInterface](../src/Handle/Command/CommandInterface.php)

And describe the command in the attribute [Command](../src/Handle/Command/Command.php)

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

And then get this parameter using [TelegramProcessHelper](../src/Helper/Process/TelegramProcessHelper.php)

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
    public function __construct(private readonly TelegramProcessHelper $processHelper) 
    {
    }

    public function __invoke(Update $update): void
    {
        $data = $this->processHelper->commandQuery($update, self::class);
        // $data = ['param' => value]
    }
}

```