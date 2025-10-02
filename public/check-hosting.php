<?php
/**
 * Script de verificación de compatibilidad del hosting
 * Ejecutar en: tudominio.com/check-hosting.php
 */

echo "<!DOCTYPE html>";
echo "<html><head><title>Verificación Hosting - InnovaCode</title>";
echo "<style>body{font-family:Arial;margin:40px;} .ok{color:green;} .error{color:red;} .warning{color:orange;}</style>";
echo "</head><body>";

echo "<h1>🔍 Verificación de Compatibilidad del Hosting</h1>";

// Verificar versión PHP
echo "<h2>PHP</h2>";
$phpVersion = phpversion();
echo "<p>Versión PHP: <strong>$phpVersion</strong> ";
if (version_compare($phpVersion, '7.4.0', '>=')) {
    echo "<span class='ok'>✅ Compatible</span>";
} else {
    echo "<span class='error'>❌ Requiere PHP 7.4+</span>";
}
echo "</p>";

// Verificar extensiones
echo "<h2>Extensiones PHP</h2>";
$required = ['pdo', 'pdo_mysql', 'json', 'mbstring', 'openssl'];
foreach ($required as $ext) {
    echo "<p>$ext: ";
    if (extension_loaded($ext)) {
        echo "<span class='ok'>✅ Disponible</span>";
    } else {
        echo "<span class='error'>❌ No disponible</span>";
    }
    echo "</p>";
}

// Verificar permisos de escritura
echo "<h2>Permisos de Escritura</h2>";
$dirs = ['logs'];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    echo "<p>Directorio $dir: ";
    if (is_writable($dir)) {
        echo "<span class='ok'>✅ Escribible</span>";
    } else {
        echo "<span class='error'>❌ Sin permisos</span>";
    }
    echo "</p>";
}

// Verificar mod_rewrite
echo "<h2>Apache mod_rewrite</h2>";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "<p><span class='ok'>✅ mod_rewrite disponible</span></p>";
    } else {
        echo "<p><span class='error'>❌ mod_rewrite no disponible</span></p>";
    }
} else {
    echo "<p><span class='warning'>⚠️ No se puede verificar (posible Nginx o configuración diferente)</span></p>";
}

// Test de conexión a base de datos
echo "<h2>Conexión Base de Datos</h2>";
try {
    // Cargar configuración
    if (file_exists('config/env.php')) {
        include_once 'config/env.php';
        
        $dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']};charset=utf8mb4";
        $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS']);
        echo "<p><span class='ok'>✅ Conexión exitosa a base de datos</span></p>";
        
        // Verificar tabla de usuarios
        $stmt = $pdo->query("SHOW TABLES LIKE 'usuarios'");
        if ($stmt->rowCount() > 0) {
            echo "<p><span class='ok'>✅ Tabla usuarios existe</span></p>";
        } else {
            echo "<p><span class='error'>❌ Tabla usuarios no encontrada - Importar newsletters.sql</span></p>";
        }
        
    } else {
        echo "<p><span class='error'>❌ Archivo config/env.php no encontrado</span></p>";
    }
} catch (Exception $e) {
    echo "<p><span class='error'>❌ Error de conexión: " . $e->getMessage() . "</span></p>";
}

// Información del servidor
echo "<h2>Información del Servidor</h2>";
echo "<p>Sistema: " . php_uname() . "</p>";
echo "<p>Servidor Web: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";

// Verificar archivos críticos
echo "<h2>Archivos del Proyecto</h2>";
$files = [
    'index.php' => 'Archivo principal',
    'config/env.php' => 'Configuración',
    'core/Router.php' => 'Sistema de rutas',
    'app/Controllers/HomeController.php' => 'Controladores'
];

foreach ($files as $file => $desc) {
    echo "<p>$desc ($file): ";
    if (file_exists($file)) {
        echo "<span class='ok'>✅ Existe</span>";
    } else {
        echo "<span class='error'>❌ No encontrado</span>";
    }
    echo "</p>";
}

echo "<hr>";
echo "<p><strong>📝 Instrucciones:</strong></p>";
echo "<ol>";
echo "<li>Corregir todos los elementos marcados con ❌</li>";
echo "<li>Importar base de datos si no existe</li>";
echo "<li>Verificar permisos de directorios</li>";
echo "<li>Eliminar este archivo después de la verificación</li>";
echo "</ol>";

echo "</body></html>";
?>