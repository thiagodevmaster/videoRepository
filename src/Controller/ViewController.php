<?php

namespace Alura\Mvc\Controller;

abstract class ViewController implements Controller
{
    private const TEMPLATE_PATH = __DIR__ . "/../../view/";

    protected function renderHTML(string $template, array $context = []): void
    {
        extract($context);
        require_once self::TEMPLATE_PATH . $template . '.php';
    }
}