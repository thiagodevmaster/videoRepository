<?php

namespace Alura\Mvc\Helper;

trait FlashMessageTrait
{
    private function addErrorMessage(string $message): void
    {
        $_SESSION['error_message'] = $message;
    }

    private function addSucessMessage(string $message): void
    {
        $_SESSION['success_message'] = $message;
    }
}