<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Helper\Update;

use Symfony\Component\HttpFoundation\RequestStack;
use TelegramBot\Api\Types\Update as TelegramUpdate;

class Update
{
    private TelegramUpdate $update;

    public function __construct(RequestStack $requestStack)
    {
        $this->update = TelegramUpdate::fromResponse($requestStack->getCurrentRequest()->toArray());
    }

    public function getUpdate(): TelegramUpdate
    {
        return $this->update;
    }
}
