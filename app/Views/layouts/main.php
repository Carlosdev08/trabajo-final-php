<?php
use Core\Helpers;
use Core\Session;
$auth = Session::get('auth');
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Helpers::e($_ENV['APP_NAME'] ?? 'InnovaCode') ?></title>

    <link rel="stylesheet" href="<?= Helpers::asset('bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= Helpers::asset('css/global-styles.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH/j2dXHp1pLl2RlLYc00Q7FNIcwiT9IBhe6A1qVP7W+57L+e5uJ/uNI0B0Pk88pndz3G2Yy4Yx04ecE3j3sQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer">

    <?php
    if (!empty($pageStyles) && is_array($pageStyles)) {
        foreach (array_unique($pageStyles) as $stylePath) {
            $fullPath = Helpers::asset($stylePath);
            echo '<link rel="stylesheet" href="' . $fullPath . '">' . "\n";
            // Debug: uncomment to see the path
            // echo '<!-- CSS Path: ' . $fullPath . ' -->' . "\n";
        }
    }
    ?>
</head>

<body>
    <?php include_once __DIR__ . '/navbar.php'; ?>
    <main class="container py-4">
        <?php include APP_PATH . '/Views/partials/flash.php'; ?>
        <?= $content ?>
    </main>

    <script src="<?= Helpers::asset('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <?php
    if (!empty($pageScripts) && is_array($pageScripts)) {
        foreach (array_unique($pageScripts) as $scriptPath) {
            $fullPath = Helpers::asset($scriptPath);
            echo '<script src="' . $fullPath . '"></script>' . "\n";
        }
    }
    ?>
</body>

</html>