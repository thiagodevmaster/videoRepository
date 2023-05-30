<?php

namespace Alura\Mvc\Helper;

trait RenderViewTrait
{
    private const TEMPLATE_PATH = __DIR__ . "/../../view/";

    private function renderView(string $template, array $context=[]): string
    {

        extract($context);
        ob_start();
        require_once self::TEMPLATE_PATH . $template . '.php';
        return ob_get_clean();
    }
}