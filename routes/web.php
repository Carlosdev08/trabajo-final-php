<?php
// Archivo de definición de rutas. Solo mapea URL -> controlador@método.
// $router viene desde public/index.php

$router->get('/', [App\Controllers\HomeController::class, 'index']);
$router->get('/noticias', [App\Controllers\NoticiasController::class, 'index']);

$router->get('/login', [App\Controllers\AuthController::class, 'showLogin']);
$router->post('/login', [App\Controllers\AuthController::class, 'login']);
$router->get('/registro', [App\Controllers\AuthController::class, 'showRegistro']);
$router->post('/registro', [App\Controllers\AuthController::class, 'register']);
$router->post('/logout', [App\Controllers\AuthController::class, 'logout']);

// RUTAS PARA USUARIOS (rol: user)
$router->get('/perfil', [App\Controllers\PerfilController::class, 'show']);
$router->post('/perfil', [App\Controllers\PerfilController::class, 'update']);

$router->get('/citaciones', [App\Controllers\CitacionesController::class, 'index']);
$router->post('/citaciones', [App\Controllers\CitacionesController::class, 'store']);
$router->post('/citaciones/update', [App\Controllers\CitacionesController::class, 'update']);
$router->post('/citaciones/delete', [App\Controllers\CitacionesController::class, 'delete']);

// TODO: RUTAS PARA ADMINISTRADORES (las crearemos después)

// Dashboard Administrativo
$router->get('/dashboard', [App\Controllers\DashboardController::class, 'index']);

$router->get('/usuarios-administracion', [App\Controllers\UsuariosAdminController::class, 'index']);
$router->post('/usuarios-administracion', [App\Controllers\UsuariosAdminController::class, 'store']);
$router->post('/usuarios-administracion/update', [App\Controllers\UsuariosAdminController::class, 'update']);
$router->post('/usuarios-administracion/delete', [App\Controllers\UsuariosAdminController::class, 'delete']);

$router->get('/citaciones-administracion', [App\Controllers\CitacionesAdminController::class, 'index']);
$router->post('/citaciones-administracion', [App\Controllers\CitacionesAdminController::class, 'store']);
$router->post('/citaciones-administracion/update', [App\Controllers\CitacionesAdminController::class, 'update']);
$router->post('/citaciones-administracion/delete', [App\Controllers\CitacionesAdminController::class, 'delete']);

$router->get('/noticias-administracion', [App\Controllers\NoticiasAdminController::class, 'index']);
$router->post('/noticias-administracion', [App\Controllers\NoticiasAdminController::class, 'store']);
$router->post('/noticias-administracion/update', [App\Controllers\NoticiasAdminController::class, 'update']);
$router->post('/noticias-administracion/delete', [App\Controllers\NoticiasAdminController::class, 'delete']);
