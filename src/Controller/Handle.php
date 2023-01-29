<?php

declare(strict_types=1);

namespace Evmv\TelegramBot\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Evmv\TelegramBot\Core\Core;

class Handle extends AbstractController
{
    public function __construct(private readonly Core $core)
    {
    }

    public function __invoke(): Response
    {
        if (!$this->core->middleware()) {
            return new Response();
        }

        $this->core->command();
        $this->core->action();
        $this->core->text();
        $this->core->uploadPhoto();
        $this->core->uploadDocument();
        $this->core->uploadVideo();
        $this->core->uploadAudio();
        $this->core->uploadContact();
        $this->core->uploadVoice();
        $this->core->invoice();
        $this->core->location();

        $this->core->any();

        return new Response();
    }
}
