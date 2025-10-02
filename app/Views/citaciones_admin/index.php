<!-- Gestión de Citas -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-calendar-check text-primary"></i>
        Gestión de Citas
    </h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaCita">
        <i class="fas fa-plus"></i>
        Nueva Cita
    </button>
</div>

<!-- Estadísticas rápidas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Citas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($citas) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Hoy</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count(array_filter($citas, function($c) { return date('Y-m-d', strtotime($c['fecha_cita'])) === date('Y-m-d'); })) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Esta Semana</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count(array_filter($citas, function($c) { 
                                $fecha = strtotime($c['fecha_cita']);
                                return $fecha >= strtotime('monday this week') && $fecha <= strtotime('sunday this week');
                            })) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Este Mes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count(array_filter($citas, function($c) { 
                                return date('Y-m', strtotime($c['fecha_cita'])) === date('Y-m');
                            })) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-filter"></i>
            Filtros y Búsqueda
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <input type="text" class="form-control" id="buscarCita" placeholder="Buscar por usuario o motivo...">
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" id="filtroFecha">
            </div>
            <div class="col-md-3">
                <select class="form-control" id="filtroUsuario">
                    <option value="">Todos los usuarios</option>
                    <?php 
                    $usuarios_unicos = array_unique(array_column($citas, 'usuario'));
                    foreach($usuarios_unicos as $usuario): ?>
                        <option value="<?= Core\Helpers::e($usuario) ?>"><?= Core\Helpers::e($usuario) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-primary w-100" onclick="buscarCitas()">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de citas -->
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-table"></i>
            Lista de Citas (<?= count($citas) ?>)
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tablaCitas">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($citas)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-calendar-times fa-3x mb-3 d-block"></i>
                                No hay citas programadas
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($citas as $cita): ?>
                            <tr>
                                <td><?= $cita['idCita'] ?></td>
                                <td>
                                    <strong><?= date('d/m/Y', strtotime($cita['fecha_cita'])) ?></strong>
                                    <small class="d-block text-muted">
                                        <?= date('l', strtotime($cita['fecha_cita'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <strong><?= Core\Helpers::e($cita['usuario']) ?></strong>
                                </td>
                                <td>
                                    <a href="mailto:<?= $cita['email'] ?>" class="text-primary">
                                        <?= Core\Helpers::e($cita['email']) ?>
                                    </a>
                                </td>
                                <td>
                                    <?php if ($cita['telefono']): ?>
                                        <a href="tel:<?= $cita['telefono'] ?>" class="text-success">
                                            <i class="fas fa-phone"></i>
                                            <?= Core\Helpers::e($cita['telefono']) ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Sin teléfono</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="text-truncate" style="max-width: 200px;" title="<?= Core\Helpers::e($cita['motivo_cita']) ?>">
                                        <?= Core\Helpers::e(substr($cita['motivo_cita'], 0, 50)) ?>
                                        <?= strlen($cita['motivo_cita']) > 50 ? '...' : '' ?>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    $fecha_cita = strtotime($cita['fecha_cita']);
                                    $hoy = strtotime(date('Y-m-d'));
                                    
                                    if ($fecha_cita < $hoy): ?>
                                        <span class="badge bg-secondary">Pasada</span>
                                    <?php elseif ($fecha_cita == $hoy): ?>
                                        <span class="badge bg-warning">Hoy</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Programada</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-info" 
                                                onclick="verCita(<?= $cita['idCita'] ?>)"
                                                title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning" 
                                                onclick="editarCita(<?= $cita['idCita'] ?>)"
                                                title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" 
                                                onclick="eliminarCita(<?= $cita['idCita'] ?>)"
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
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

<!-- Modal Nueva Cita -->
<div class="modal fade" id="modalNuevaCita" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-plus"></i>
                    Programar Nueva Cita
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?= Core\Helpers::baseUrl('/citaciones-administracion') ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Usuario *</label>
                                <select class="form-control" name="idUsuario" required>
                                    <option value="">Seleccionar usuario</option>
                                    <?php foreach ($usuarios as $user): ?>
                                        <option value="<?= $user['idUsuario'] ?>">
                                            <?= Core\Helpers::e($user['usuario']) ?> (<?= Core\Helpers::e($user['email']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha de la Cita *</label>
                                <input type="date" class="form-control" name="fecha_cita" 
                                       min="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Motivo de la Cita *</label>
                                <textarea class="form-control" name="motivo_cita" rows="4" 
                                          placeholder="Describe el motivo de la cita..." required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Programar Cita
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function buscarCitas() {
    const buscar = document.getElementById('buscarCita').value.toLowerCase();
    const filtroFecha = document.getElementById('filtroFecha').value;
    const filtroUsuario = document.getElementById('filtroUsuario').value.toLowerCase();
    const tabla = document.getElementById('tablaCitas');
    const filas = tabla.getElementsByTagName('tr');

    for (let i = 1; i < filas.length; i++) {
        const fila = filas[i];
        const texto = fila.textContent.toLowerCase();
        const fechaCita = fila.cells[1]?.textContent || '';
        const usuario = fila.cells[2]?.textContent.toLowerCase() || '';
        
        let mostrar = true;
        
        if (buscar && !texto.includes(buscar)) {
            mostrar = false;
        }
        
        if (filtroFecha && !fechaCita.includes(filtroFecha.split('-').reverse().join('/'))) {
            mostrar = false;
        }
        
        if (filtroUsuario && !usuario.includes(filtroUsuario)) {
            mostrar = false;
        }
        
        fila.style.display = mostrar ? '' : 'none';
    }
}

function verCita(id) {
    alert('Ver detalles de la cita ID: ' + id);
}

function editarCita(id) {
    alert('Editar cita ID: ' + id);
}

function eliminarCita(id) {
    if (confirm('¿Estás seguro de que quieres eliminar esta cita?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= Core\Helpers::baseUrl('/citaciones-administracion/delete') ?>';
        form.innerHTML = `<input type="hidden" name="id" value="${id}">`;
        document.body.appendChild(form);
        form.submit();
    }
}

// Búsqueda en tiempo real
document.getElementById('buscarCita').addEventListener('input', buscarCitas);
document.getElementById('filtroFecha').addEventListener('change', buscarCitas);
document.getElementById('filtroUsuario').addEventListener('change', buscarCitas);
</script>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df!important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a!important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc!important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e!important;
}

.text-xs {
    font-size: 0.75rem;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}
</style>