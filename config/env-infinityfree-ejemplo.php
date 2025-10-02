<?php
// CONFIGURACIÓN PARA INFINITYFREE
// ¡ACTUALIZA ESTOS DATOS CON LOS QUE TE DÉ INFINITYFREE!

$_ENV['APP_NAME'] = 'InnovaCode';
$_ENV['APP_URL'] = 'https://tusubdominio.infinityfreeapp.com'; // ← CAMBIA ESTO
$_ENV['APP_DEBUG'] = false; // ← IMPORTANTE: false en producción

// DATOS DE LA BASE DE DATOS (los que te dé InfinityFree)
$_ENV['DB_HOST'] = 'sqlXXX.infinityfree.net'; // ← CAMBIA ESTO
$_ENV['DB_PORT'] = 3306;
$_ENV['DB_NAME'] = 'epizXXX_newsletters'; // ← CAMBIA ESTO  
$_ENV['DB_USER'] = 'epizXXX_user';        // ← CAMBIA ESTO
$_ENV['DB_PASS'] = 'tu_password_bd';      // ← CAMBIA ESTO

// Configuración de sesiones
$_ENV['SESSION_SECURE'] = true;  // HTTPS en producción
$_ENV['SESSION_HTTPONLY'] = true;