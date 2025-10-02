<?php use Core\Helpers;
use Core\Session;
$auth = Session::get('auth'); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="<?= Helpers::baseUrl('/') ?>">
            <strong>InnovaCode</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= Helpers::baseUrl('/') ?>">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Helpers::baseUrl('/noticias') ?>">Noticias</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Servicios
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= Helpers::baseUrl('/servicios') ?>">
                            <i class="fas fa-list me-2"></i>Todos los Servicios</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= Helpers::baseUrl('/servicios/desarrollo-web') ?>">
                            <i class="fas fa-code me-2"></i>Desarrollo Web</a></li>
                        <li><a class="dropdown-item" href="<?= Helpers::baseUrl('/servicios/base-datos') ?>">
                            <i class="fas fa-database me-2"></i>Base de Datos</a></li>
                        <li><a class="dropdown-item" href="<?= Helpers::baseUrl('/servicios/apps-moviles') ?>">
                            <i class="fas fa-mobile-alt me-2"></i>Apps Móviles</a></li>
                        <li><a class="dropdown-item" href="<?= Helpers::baseUrl('/servicios/consultoria') ?>">
                            <i class="fas fa-lightbulb me-2"></i>Consultoría</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= Helpers::baseUrl('/servicios/contacto') ?>">
                            <i class="fas fa-envelope me-2"></i>Contactar</a></li>
                    </ul>
                </li>

                <?php if ($auth && $auth['rol'] === 'user'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Helpers::baseUrl('/citaciones') ?>">Citaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Helpers::baseUrl('/perfil') ?>">Perfil</a>
                    </li>
                <?php elseif ($auth && $auth['rol'] === 'admin'): ?>
                    <!-- Dashboard principal para admin -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Helpers::baseUrl('/dashboard') ?>">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>

                    <!-- Dropdown para gestión -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-cogs"></i> Gestión
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?= Helpers::baseUrl('/usuarios-administracion') ?>">
                                    <i class="fas fa-users"></i> Usuarios
                                </a></li>
                            <li><a class="dropdown-item" href="<?= Helpers::baseUrl('/citaciones-administracion') ?>">
                                    <i class="fas fa-calendar-check"></i> Citaciones
                                </a></li>
                            <li><a class="dropdown-item" href="<?= Helpers::baseUrl('/noticias-administracion') ?>">
                                    <i class="fas fa-newspaper"></i> Noticias
                                </a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= Helpers::baseUrl('/perfil') ?>">
                            <i class="fas fa-user"></i> Perfil
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav">
                <?php if (!$auth): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Helpers::baseUrl('/login') ?>">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Helpers::baseUrl('/registro') ?>">Registro</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <span class="navbar-text me-3">
                            <i class="fas fa-user-circle"></i>
                            <?= Helpers::e($auth['usuario']) ?>
                            <span class="badge bg-<?= $auth['rol'] === 'admin' ? 'warning' : 'success' ?> ms-1">
                                <?= ucfirst($auth['rol']) ?>
                            </span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <form method="post" action="<?= Helpers::baseUrl('/logout') ?>" class="d-inline">
                            <button class="btn btn-outline-light btn-sm">Cerrar Sesión</button>
                        </form>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>