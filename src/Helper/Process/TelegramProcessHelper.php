<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Helper\Process;

use Evmv\TelegramBot\Handle\Command\Command;
use Evmv\TelegramBot\Helper\ClassHelper\ClassHelper;
use TelegramBot\Api\Types\Update;

class TelegramProcessHelper
{
    public function __construct(private readonly ClassHelper $classHelper)
    {
    }

    public function callbackQueryPayload(Update $update): ?array
    {
        $callbackQuery = $update->getCallbackQuery();
        if (is_null($callbackQuery) || !strlen($callbackQuery->getData())) {
            return null;
        }

        return json_decode($callbackQuery->getData(), true);
    }

    public function commandQuery(Update $update, string $class): ?array
    {
        $attribute = $this->classHelper->getClassAttribute($class, Command::class);

        $command = $attribute['command'];
        $text = $update->getMessage()->getText();

        $commandWithOutQueryParam = trim(preg_replace("/\{([^{}]*+|(?R))*\}/",' ', $command));
        $patterns = explode(' ', $commandWithOutQueryParam);

        $queryParamsValue = $this->queryParamValue($text, $patterns);
        $queryParamsName = $this->queryParamName($command, $patterns);

        if (empty($queryParamsName[0]))
        {
            return null;
        }

        $queryParams = [];
        for ($i = 0; $i < count($queryParamsName); $i++) {
            $queryParams[$queryParamsName[$i]] = $queryParamsValue[$i] ?? null;
        }

        return $queryParams;
    }

    private function replaceFirst(string $search, string $replace, string $subject): string
    {
        $pos = strpos($subject, $search);
        if ($pos !== false) {
            return substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }

    private function queryParamValue(string $text, array $patterns): ?array
    {
        foreach ($patterns as $pattern) {
            $text = $this->replaceFirst($pattern, ' ', $text);
        }

        return explode(' ', trim($text));
    }

    private function queryParamName(string $command, array $patterns): ?array
    {
        $queryParamsName = $this->queryParamValue($command, $patterns);

        return str_replace(['{', '}'], '', $queryParamsName);
    }
}