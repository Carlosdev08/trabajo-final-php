<?php
namespace Core;


abstract class Controller
{
    protected function view(string $template, array $data = [], ?string $layout = 'layouts/main'): string
    {
        return View::render($template, $data, $layout);
    }


    protected function redirect(string $to): void
    {
        header('Location: ' . $to);
        exit;
    }
}
