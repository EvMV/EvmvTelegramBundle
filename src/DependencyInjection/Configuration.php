<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('evmv_telegram');

        return $treeBuilder;
    }
}