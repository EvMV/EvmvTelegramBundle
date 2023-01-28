### Text
To process incoming text, use a class that implements the [TextInterface](https://github.com/EvMV/EvmvTelegramBundle/src/Handle/Text/TextInterface.php).

And also the attribute that describes the [Text](https://github.com/EvMV/EvmvTelegramBundle/src/Handle/Text/Text.php).

Example:
```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Evmv\TelegramBot\Handle\Text\TextInterface;
use Evmv\TelegramBot\Handle\Text\Text;
use TelegramBot\Api\Types\Update;

#[Text(text: 'Hello world')]
class TextProcess implements TextInterface
{
    public function __invoke(Update $update): void
    {
        // Do something
    }
}

```