## About 
The bundle uses annotations, which allows you to create 
flexible telegram bot systems.

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

Add your bot key to .env:
```dotenv
BOT_KEY=your_telegram_bot_key
```

And add route to config/routes.yaml:
```yaml
telegram:
    path: /handle
    controller: Evmv\TelegramBot\Controller\Handle::__invoke
```

## Usage ##
- [COMMAND](docs/COMMAND.md)
- [KEYBOARD](docs/KEYBOARD.md)
- [TEXT](docs/TEXT.md)
- [MIDDLEWARE](docs/MIDDLEWARE.md)
- [EVENT](docs/EVENT.md)

### How To Contribute
To contribute just open a Pull Request with your new code taking into account that if you add new features or modify existing ones you have to document in this README what they do. If you break BC then you have to document it as well.