<?php
use Core\Helpers;

$pageStyles = array_unique(array_merge($pageStyles ?? [], ['css/admin-styles.css']));
$pageScripts = array_unique(array_merge($pageScripts ?? [], ['js/usuarios-admin.js']));
?>
<section class="usuarios-admin-container">
    <div class="usuarios-admin-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-white">
                <i class="fas fa-users me-2"></i>
                Gestion de Usuarios
            </h1>
            <p class="mb-0 text-white-50">Administra cuentas, roles y datos personales de los usuarios registrados.</p>
        </div>
        <button class="btn btn-light mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#modalNuevoUsuario">
            <i class="fas fa-plus me-2"></i>
            <span class="d-none d-sm-inline">Nuevo</span> Usuario
        </button>
    </div>

    <div class="filtros-container mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-6 col-lg-4">
                <label class="form-label" for="buscarUsuario">Buscar</label>
                <div class="search-input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" id="buscarUsuario" placeholder="Nombre, email o usuario">
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <label class="form-label" for="filtroRol">Rol</label>
                <select class="form-select" id="filtroRol">
                    <option value="">Todos los roles</option>
                    <option value="admin">Administradores</option>
                    <option value="user">Usuarios</option>
                </select>
            </div>
            <div class="col-md-2 col-lg-2">
                <label class="form-label d-none d-md-block">&nbsp;</label>
                <button type="button" class="btn btn-outline-primary w-100" data-user-action="filter">
                    <i class="fas fa-filter me-1"></i>
                    Aplicar
                </button>
            </div>
        </div>
    </div>

    <div class="tabla-usuarios card-custom">
        <div class="d-flex justify-content-between align-items-center px-3 py-3 border-bottom bg-light">
            <h2 class="h5 mb-0"><i class="fas fa-table me-2"></i>Lista de usuarios</h2>
            <span class="badge bg-secondary">Total: <?= count($usuarios) ?></span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="tablaUsuarios">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th class="d-none d-md-table-cell">Email</th>
                        <th>Nombre</th>
                        <th class="d-none d-lg-table-cell">Telefono</th>
                        <th class="d-none d-xl-table-cell">Ciudad</th>
                        <th class="d-none d-sm-table-cell">Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($usuarios)): ?>
                        <tr>
                            <td colspan="8" class="table-empty-state">
                                <i class="fas fa-users mb-3"></i>
                                <h5>No hay usuarios registrados</h5>
                                <p>Cuando crees nuevos usuarios apareceran listados aqui.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <?php
                                $fullName = trim(($usuario['nombre'] ?? '') . ' ' . ($usuario['apellidos'] ?? ''));
                                $telefono = $usuario['telefono'] ?? '';
                                $ciudad = $usuario['ciudad'] ?? '';
                                $rol = strtolower($usuario['rol'] ?? 'user');
                            ?>
                            <tr
                                data-user-id="<?= Helpers::e((string) $usuario['idLogin']) ?>"
                                data-username="<?= Helpers::e($usuario['usuario']) ?>"
                                data-email="<?= Helpers::e($usuario['email']) ?>"
                                data-full-name="<?= Helpers::e($fullName) ?>"
                                data-first-name="<?= Helpers::e($usuario['nombre'] ?? '') ?>"
                                data-last-name="<?= Helpers::e($usuario['apellidos'] ?? '') ?>"
                                data-phone="<?= Helpers::e($telefono) ?>"
                                data-city="<?= Helpers::e($ciudad) ?>"
                                data-role="<?= Helpers::e($rol) ?>"
                            >
                                <td><?= Helpers::e((string) $usuario['idLogin']) ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-2">
                                            <?= strtoupper(substr($usuario['usuario'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <strong><?= Helpers::e($usuario['usuario']) ?></strong>
                                            <div class="d-md-none small text-muted">
                                                <i class="fas fa-envelope me-1"></i><?= Helpers::e($usuario['email']) ?>
                                            </div>
                                            <div class="d-sm-none small text-muted">
                                                <i class="fas fa-user me-1"></i><?= Helpers::e($fullName) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell text-truncate" style="max-width: 220px;">
                                    <a href="mailto:<?= Helpers::e($usuario['email']) ?>" class="text-decoration-none">
                                        <?= Helpers::e($usuario['email']) ?>
                                    </a>
                                </td>
                                <td><?= Helpers::e($fullName) ?></td>
                                <td class="d-none d-lg-table-cell">
                                    <?php if ($telefono): ?>
                                        <a href="tel:<?= Helpers::e($telefono) ?>" class="text-success text-decoration-none">
                                            <i class="fas fa-phone me-1"></i><?= Helpers::e($telefono) ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Sin Telefono</span>
                                    <?php endif; ?>
                                </td>
                                <td class="d-none d-xl-table-cell"><?= Helpers::e($ciudad ?: 'Sin especificar') ?></td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="badge bg-<?= $rol === 'admin' ? 'warning' : 'success' ?> text-uppercase">
                                        <?= Helpers::e($rol === 'admin' ? 'Admin' : 'User') ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm btn-group-actions" role="group">
                                    <button type="button" class="btn btn-outline-info btn-action" data-user-action="view" data-user-id="<?= Helpers::e((string) $usuario['idLogin']) ?>">
                                            <i class="fas fa-eye"></i>
                                            <span class="d-none d-lg-inline ms-1">Ver</span>
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-action" data-user-action="edit" data-user-id="<?= Helpers::e((string) $usuario['idLogin']) ?>">
                                            <i class="fas fa-edit"></i>
                                            <span class="d-none d-lg-inline ms-1">Editar</span>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-action" data-user-action="delete" data-user-id="<?= Helpers::e((string) $usuario['idLogin']) ?>">
                                            <i class="fas fa-trash"></i>
                                            <span class="d-none d-lg-inline ms-1">Eliminar</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal: Nuevo usuario -->
<div class="modal fade" id="modalNuevoUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Crear nuevo usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form method="post" action="<?= Helpers::baseUrl('/usuarios-administracion') ?>">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <h6 class="text-primary mb-3"><i class="fas fa-key me-2"></i>Datos de acceso</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Usuario *</label>
                            <input type="text" name="usuario" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contrasena *</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rol *</label>
                            <select name="rol" class="form-select" required>
                                <option value="">Seleccionar rol</option>
                                <option value="user">Usuario</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <hr>
                            <h6 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Datos personales</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellidos *</label>
                            <input type="text" name="apellidos" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telefono *</label>
                            <input type="tel" name="telefono" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha de nacimiento *</label>
                            <input type="date" name="fecha_nacimiento" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sexo</label>
                            <select name="sexo" class="form-select">
                                <option value="">Seleccionar</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ciudad</label>
                            <input type="text" name="ciudad" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Codigo postal</label>
                            <input type="text" name="codigoPostal" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Direccion</label>
                            <textarea name="direccion" class="form-control" rows="2" placeholder="Direccion completa"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Crear usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Ver usuario -->
<div class="modal fade" id="modalVerUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-circle me-2"></i>Detalles del usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoVerUsuario"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Editar usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Editar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form method="post" action="<?= Helpers::baseUrl('/usuarios-administracion/update') ?>">
                <div class="modal-body" id="contenidoEditarUsuario"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-2"></i>Actualizar usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Confirmar eliminacion -->
<div class="modal fade" id="modalEliminarUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirmar eliminacion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-user-times fa-3x text-danger mb-3"></i>
                <p class="mb-2">Esta accion No se puede deshacer. El usuario sera eliminado permanentemente.</p>
                <div class="alert alert-warning mb-0">
                    <strong>Usuario:</strong> <span id="usuarioAEliminar"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form method="post" action="<?= Helpers::baseUrl('/usuarios-administracion/delete') ?>" class="d-inline">
                    <input type="hidden" name="id" id="idUsuarioAEliminar">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>



