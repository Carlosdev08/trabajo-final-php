<?php
namespace Core;

final class View
{
    public static function render(string $template, array $data = [], ?string $layout = 'layouts/main'): string
    {
        $tplPath = APP_PATH . '/Views/' . $template . '.php';
        if (!is_file($tplPath)) {
            return 'Vista no encontrada: ' . htmlspecialchars($template);
        }

        extract($data, EXTR_SKIP);
        ob_start();
        include $tplPath;
        $content = ob_get_clean();

        if ($layout) {
            $layoutPath = APP_PATH . '/Views/' . $layout . '.php';
            if (!is_file($layoutPath)) {
                return $content;
            }

            ob_start();
            include $layoutPath;
            return ob_get_clean();
        }

        return $content;
    }

    public static function component(string $name, array $props = []): string
    {
        $compPath = APP_PATH . '/Views/components/' . $name . '.php';
        if (!is_file($compPath)) {
            return '';
        }

        ob_start();
        extract($props, EXTR_SKIP);
        include $compPath;
        return ob_get_clean();
    }
}
