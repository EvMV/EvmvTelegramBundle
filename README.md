## About 
Bundle of wildcard attributes for the description of telegram functions.
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
- [COMMAND](docs/COMMAND.md)
- [KEYBOARD](docs/KEYBOARD.md)
- [TEXT](docs/TEXT.md)
- [MIDDLEWARE](docs/MIDDLEWARE.md)
- [EVENT](docs/EVENT.md)

### How To Contribute
To contribute just open a Pull Request with your new code taking into account that if you add new features or modify existing ones you have to document in this README what they do. If you break BC then you have to document it as well.