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

#[Text(text: 'Hello world')]
#[Middleware(class: UserHaveEnoughMoney::class)]
class TextProcess implements CommandInterface
{
    public function __invoke(Update $update): void
    {
        // Do something
    }
}

```

The handler class must implement the [MiddlewareInterface](../src/Handle/Middleware/Local/MiddlewareInterface.php).

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

### GlobalMiddleware:
If you need to perform a filter before executing any function, create a class that implements the [GlobalMiddlewareInterface](../src/Handle/Middleware/Global/GlobalMiddlewareInterface.php).

You may need this when you need to protect against spam from a specific user:
```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Evmv\TelegramBot\Handle\Middleware\Global\GlobalMiddleware;
use Evmv\TelegramBot\Handle\Middleware\Global\GlobalMiddlewareInterface;
use TelegramBot\Api\Types\Update;

#[GlobalMiddleware]
class TextProcess implements GlobalMiddlewareInterface
{
    public function middleware(Update &$update): bool
    {
        // Checking if the user is a spammer
    }
}

```