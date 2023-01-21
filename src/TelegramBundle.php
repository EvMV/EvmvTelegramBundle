<?php

declare(strict_types=1);

namespace Evmv\TelegramBot;

use Evmv\TelegramBot\Handle\GeneralInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class TelegramBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->registerForAutoconfiguration(GeneralInterface::class)->addTag('telegram.general');
    }
}
