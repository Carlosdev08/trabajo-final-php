<!-- Gestión de Usuarios -->
<div class="usuarios-admin-container">
    <div class="usuarios-admin-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h1>
                <i class="fas fa-users me-2"></i>
                Gestión de Usuarios
            </h1>
            <button type="button" class="btn btn-light btn-lg shadow-sm" data-bs-toggle="modal"
                data-bs-target="#modalNuevoUsuario" title="Crear un nuevo usuario en el sistema">
                <i class="fas fa-user-plus me-2"></i>
                <span class="d-none d-sm-inline">Crear </span>Nuevo Usuario
            </button>
        </div>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="filtros-container">
        <div class="row g-3">
            <div class="col-md-6 col-lg-4">
                <label for="buscarUsuario" class="form-label">Buscar Usuario</label>
                <div class="search-input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="buscarUsuario" class="form-control"
                        placeholder="Buscar por nombre, email o usuario...">
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <label for="filtroRol" class="form-label">Filtrar por Rol</label>
                <select id="filtroRol" class="form-select">
                    <option value="">Todos los roles</option>
                    <option value="admin">Administradores</option>
                    <option value="user">Usuarios</option>
                </select>
            </div>
            <div class="col-md-12 col-lg-5">
                <div class="d-flex align-items-end h-100">
                    <div class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Total: <?= count($usuarios) ?> usuario(s) registrado(s)
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="tabla-usuarios">
        <div class="table-responsive">
            <table class="table mb-0" id="tablaUsuarios">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th class="d-none d-md-table-cell">Email</th>
                        <th>Nombre Completo</th>
                        <th class="d-none d-lg-table-cell">Teléfono</th>
                        <th class="d-none d-xl-table-cell">Ciudad</th>
                        <th class="d-none d-sm-table-cell">Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($usuarios)): ?>
                        <tr>
                            <td colspan="8">
                                <div class="table-empty-state">
                                    <i class="fas fa-users"></i>
                                    <h5>No hay usuarios registrados</h5>
                                    <p>Comienza creando tu primer usuario</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr class="fade-in" data-user-id="<?= $usuario['idLogin'] ?>"
                                data-username="<?= Core\Helpers::e($usuario['usuario']) ?>"
                                data-email="<?= Core\Helpers::e($usuario['email']) ?>"
                                data-full-name="<?= Core\Helpers::e($usuario['nombre'] . ' ' . $usuario['apellidos']) ?>"
                                data-first-name="<?= Core\Helpers::e($usuario['nombre']) ?>"
                                data-last-name="<?= Core\Helpers::e($usuario['apellidos']) ?>"
                                data-phone="<?= Core\Helpers::e($usuario['telefono'] ?? '') ?>"
                                data-city="<?= Core\Helpers::e($usuario['ciudad'] ?? '') ?>" data-role="<?= $usuario['rol'] ?>">
                                <td class="fw-bold text-primary"><?= $usuario['idLogin'] ?></td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <div class="user-name"><?= Core\Helpers::e($usuario['usuario']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell"><?= Core\Helpers::e($usuario['email']) ?></td>
                                <td><?= Core\Helpers::e($usuario['nombre'] . ' ' . $usuario['apellidos']) ?></td>
                                <td class="d-none d-lg-table-cell">
                                    <?php if (!empty($usuario['telefono'])): ?>
                                        <a href="tel:<?= Core\Helpers::e($usuario['telefono']) ?>" class="text-decoration-none">
                                            <i class="fas fa-phone text-success me-1"></i>
                                            <?= Core\Helpers::e($usuario['telefono']) ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Sin teléfono</span>
                                    <?php endif; ?>
                                </td>
                                <td class="d-none d-xl-table-cell">
                                    <?= Core\Helpers::e($usuario['ciudad'] ?? 'Sin especificar') ?>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="badge-rol <?= $usuario['rol'] === 'admin' ? 'badge-admin' : 'badge-user' ?>">
                                        <?= ucfirst($usuario['rol']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-primary" data-user-action="view"
                                            data-user-id="<?= $usuario['idLogin'] ?>" title="Ver información completa">
                                            <i class="fas fa-eye"></i>Ver
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" data-user-action="edit"
                                            data-user-id="<?= $usuario['idLogin'] ?>" title="Editar usuario">
                                            <i class="fas fa-edit"></i>Editar
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-user-action="delete"
                                            data-user-id="<?= $usuario['idLogin'] ?>" title="Eliminar usuario">
                                            <i class="fas fa-trash"></i>Eliminar
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
</div>

<!-- Modal Nuevo Usuario -->
<div class="modal fade" id="modalNuevoUsuario" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i>
                    Crear Nuevo Usuario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form method="POST" action="<?= Core\Helpers::baseUrl('/usuarios-administracion/store') ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-key me-1"></i> Datos de Acceso
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Usuario *</label>
                                <input type="text" class="form-control" name="usuario" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Contraseña *</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Confirmar Contraseña *</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rol *</label>
                                <select class="form-select" name="rol" required>
                                    <option value="">Seleccionar rol</option>
                                    <option value="user">Usuario</option>
                                    <option value="admin">Administrador</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr>
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-user me-1"></i> Datos Personales
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre *</label>
                                <input type="text" class="form-control" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Apellidos *</label>
                                <input type="text" class="form-control" name="apellidos" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" name="telefono">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Ciudad</label>
                                <input type="text" class="form-control" name="ciudad">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i>
                        Crear Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ver Usuario -->
<div class="modal fade" id="modalVerUsuario" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-circle me-2"></i>
                    Detalles del Usuario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body" id="contenidoVerUsuario">
                <!-- Contenido dinámico -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="fas fa-user-edit me-2"></i>
                    Editar Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="<?= Core\Helpers::baseUrl('/usuarios-administracion/update') ?>">
                <div class="modal-body" id="contenidoEditarUsuario">
                    <!-- Contenido dinámico -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i>
                        Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Confirmar Eliminación -->
<div class="modal fade" id="modalEliminarUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-user-times fa-3x text-danger mb-3"></i>
                <h5>¿Estás seguro?</h5>
                <p class="text-muted">Esta acción no se puede deshacer. El usuario será eliminado permanentemente.</p>
                <div class="alert alert-warning">
                    <strong>Usuario:</strong> <span id="usuarioAEliminar"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="<?= Core\Helpers::baseUrl('/usuarios-administracion/delete') ?>"
                    class="d-inline">
                    <input type="hidden" name="id" id="idUsuarioAEliminar">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>
                        Sí, Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Inicializar la gestión de usuarios cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function () {
        // Verificar que la clase UsuariosAdmin existe
        if (typeof UsuariosAdmin !== 'undefined') {
            const usuariosAdmin = new UsuariosAdmin();
            console.log('UsuariosAdmin inicializado correctamente');
        } else {
            console.error('La clase UsuariosAdmin no está disponible');
        }
    });
</script>