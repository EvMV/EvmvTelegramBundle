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
class CustomEvent implements AnyInterface
{
    public function __invoke(Update $update): void
    {
        // Do something
    }
}

```