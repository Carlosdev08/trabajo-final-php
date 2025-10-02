<!-- Gestión de Noticias -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-newspaper text-primary"></i>
        Gestión de Noticias
    </h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaNoticia">
        <i class="fas fa-plus"></i>
        Nueva Noticia
    </button>
</div>

<!-- Estadísticas rápidas -->
<div class="row mb-4">
    <div class="col-6 col-lg-3 mb-3 mb-lg-0">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Noticias</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($noticias) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 mb-3 mb-lg-0">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Este Mes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count(array_filter($noticias, function ($n) {
                                return date('Y-m', strtotime($n['fecha'])) === date('Y-m');
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
    <div class="col-6 col-lg-3 mb-3 mb-lg-0">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Esta Semana</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count(array_filter($noticias, function ($n) {
                                $fecha = strtotime($n['fecha']);
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
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Autores Únicos</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count(array_unique(array_map(function ($n) {
                                return $n['nombre'] . ' ' . $n['apellidos'];
                            }, $noticias))) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
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
                <input type="text" class="form-control" id="buscarNoticia" placeholder="Buscar por título o texto...">
            </div>
            <div class="col-md-3">
                <select class="form-control" id="filtroAutor">
                    <option value="">Todos los autores</option>
                    <?php
                    $autores_unicos = array_unique(array_map(function ($n) {
                        return $n['nombre'] . ' ' . $n['apellidos'];
                    }, $noticias));
                    foreach ($autores_unicos as $autor): ?>
                        <option value="<?= Core\Helpers::e($autor) ?>"><?= Core\Helpers::e($autor) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" id="filtroFecha">
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-primary w-100" onclick="buscarNoticias()">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de noticias -->
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-table"></i>
            Lista de Noticias (<?= count($noticias) ?>)
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tablaNoticias">
                <thead class="table-dark">
                    <tr>
                        <th class="d-none d-md-table-cell">ID</th>
                        <th>Título</th>
                        <th class="d-none d-lg-table-cell">Autor</th>
                        <th class="d-none d-sm-table-cell">Fecha</th>
                        <th class="d-none d-xl-table-cell">Contenido</th>
                        <th class="d-none d-md-table-cell">Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($noticias)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-newspaper fa-3x mb-3 d-block"></i>
                                No hay noticias publicadas
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($noticias as $noticia): ?>
                            <tr>
                                <td class="d-none d-md-table-cell"><?= $noticia['idNoticia'] ?></td>
                                <td>
                                    <strong class="text-primary">
                                        <?= Core\Helpers::e(substr($noticia['titulo'], 0, 50)) ?>
                                        <?= strlen($noticia['titulo']) > 50 ? '...' : '' ?>
                                    </strong>
                                    <?php if (strlen($noticia['titulo']) > 50): ?>
                                        <small class="d-block text-muted" title="<?= Core\Helpers::e($noticia['titulo']) ?>">
                                            Ver título completo
                                        </small>
                                    <?php endif; ?>
                                    <!-- Info adicional visible solo en móviles -->
                                    <div class="d-lg-none">
                                        <small class="text-muted d-block">
                                            <i class="fas fa-user"></i>
                                            <?= Core\Helpers::e($noticia['nombre'] . ' ' . $noticia['apellidos']) ?>
                                        </small>
                                        <small class="text-muted d-sm-none d-block">
                                            <i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($noticia['fecha'])) ?>
                                        </small>
                                    </div>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    <strong><?= Core\Helpers::e($noticia['nombre'] . ' ' . $noticia['apellidos']) ?></strong>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <strong><?= date('d/m/Y', strtotime($noticia['fecha'])) ?></strong>
                                    <small class="d-block text-muted">
                                        <?= date('H:i', strtotime($noticia['fecha'])) ?>
                                    </small>
                                </td>
                                <td class="d-none d-xl-table-cell">
                                    <div class="text-truncate" style="max-width: 250px;"
                                        title="<?= Core\Helpers::e($noticia['texto']) ?>">
                                        <?= Core\Helpers::e(substr($noticia['texto'], 0, 100)) ?>
                                        <?= strlen($noticia['texto']) > 100 ? '...' : '' ?>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <?php
                                    $fecha_noticia = strtotime($noticia['fecha']);
                                    $hace_dias = floor((time() - $fecha_noticia) / (60 * 60 * 24));

                                    if ($hace_dias == 0): ?>
                                        <span class="badge bg-success">Hoy</span>
                                    <?php elseif ($hace_dias <= 7): ?>
                                        <span class="badge bg-warning">Reciente</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Antigua</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm d-flex d-sm-inline-flex" role="group">
                                        <button class="btn btn-outline-info flex-fill"
                                            onclick="verNoticia(<?= $noticia['idNoticia'] ?>)" title="Ver completa">
                                            <i class="fas fa-eye"></i>
                                            <span class="d-none d-lg-inline ms-1">Ver</span>
                                        </button>
                                        <button class="btn btn-outline-warning flex-fill"
                                            onclick="editarNoticia(<?= $noticia['idNoticia'] ?>)" title="Editar">
                                            <i class="fas fa-edit"></i>
                                            <span class="d-none d-lg-inline ms-1">Editar</span>
                                        </button>
                                        <button class="btn btn-danger flex-fill"
                                            onclick="eliminarNoticia(<?= $noticia['idNoticia'] ?>)" title="Eliminar">
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
</div>

<!-- Modal Nueva Noticia -->
<div class="modal fade" id="modalNuevaNoticia" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-newspaper"></i>
                    Crear Nueva Noticia
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?= Core\Helpers::baseUrl('/noticias-administracion') ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Título de la Noticia *</label>
                                <input type="text" class="form-control" name="titulo"
                                    placeholder="Ingresa un título llamativo..." required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Contenido de la Noticia *</label>
                                <textarea class="form-control" name="texto" rows="10"
                                    placeholder="Escribe el contenido completo de la noticia..." required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha de Publicación</label>
                                <input type="date" class="form-control" name="fecha" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Publicar Noticia
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ver Noticia -->
<div class="modal fade" id="modalVerNoticia" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-newspaper"></i>
                    Detalles de la Noticia
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="contenidoVerNoticia">
                <!-- Contenido cargado dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Noticia -->
<div class="modal fade" id="modalEditarNoticia" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Editar Noticia
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?= Core\Helpers::baseUrl('/noticias-administracion/update') ?>">
                <div class="modal-body" id="contenidoEditarNoticia">
                    <!-- Contenido dinámico -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i>
                        Actualizar Noticia
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Confirmar Eliminación de Noticia -->
<div class="modal fade" id="modalEliminarNoticia" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-newspaper fa-3x text-danger mb-3"></i>
                <h5>¿Estás seguro?</h5>
                <p class="text-muted">Esta acción no se puede deshacer. La noticia será eliminada permanentemente.</p>
                <div class="alert alert-warning">
                    <strong>Noticia:</strong> <span id="noticiaAEliminar"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="<?= Core\Helpers::baseUrl('/noticias-administracion/delete') ?>"
                    class="d-inline">
                    <input type="hidden" name="idNoticia" id="idNoticiaAEliminar">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i>
                        Sí, Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function buscarNoticias() {
        const buscar = document.getElementById('buscarNoticia').value.toLowerCase();
        const filtroAutor = document.getElementById('filtroAutor').value.toLowerCase();
        const filtroFecha = document.getElementById('filtroFecha').value;
        const tabla = document.getElementById('tablaNoticias');
        const filas = tabla.getElementsByTagName('tr');

        for (let i = 1; i < filas.length; i++) {
            const fila = filas[i];
            const texto = fila.textContent.toLowerCase();
            const autor = fila.cells[2]?.textContent.toLowerCase() || '';
            const fechaNoticia = fila.cells[3]?.textContent || '';

            let mostrar = true;

            if (buscar && !texto.includes(buscar)) {
                mostrar = false;
            }

            if (filtroAutor && !autor.includes(filtroAutor)) {
                mostrar = false;
            }

            if (filtroFecha && !fechaNoticia.includes(filtroFecha.split('-').reverse().join('/'))) {
                mostrar = false;
            }

            fila.style.display = mostrar ? '' : 'none';
        }
    }

    function verNoticia(id) {
        // Encontrar la noticia en los datos
        const noticias = <?= json_encode($noticias) ?>;
        const noticia = noticias.find(n => n.idNoticia == id);

        if (noticia) {
            document.getElementById('contenidoVerNoticia').innerHTML = `
            <div class="mb-3">
                <h4 class="text-primary">${noticia.titulo}</h4>
                <p class="text-muted">
                    <strong>Autor:</strong> ${noticia.autor} | 
                    <strong>Fecha:</strong> ${new Date(noticia.fecha).toLocaleDateString('es-ES')}
                </p>
            </div>
            <div class="border-top pt-3">
                <p style="white-space: pre-wrap; line-height: 1.6;">${noticia.texto}</p>
            </div>
        `;
            new bootstrap.Modal(document.getElementById('modalVerNoticia')).show();
        }
    }

    function editarNoticia(id) {
        // Encontrar los datos de la noticia en la tabla
        const filas = document.getElementById('tablaNoticias').getElementsByTagName('tr');
        let noticia = null;

        for (let i = 1; i < filas.length; i++) {
            const celdas = filas[i].getElementsByTagName('td');
            const idNoticia = celdas[0] ? celdas[0].textContent : celdas[1].querySelector('button').onclick.toString().match(/\d+/)[0];

            if (idNoticia == id) {
                noticia = {
                    id: id,
                    titulo: celdas[1] ? celdas[1].querySelector('strong').textContent : celdas[0].querySelector('strong').textContent,
                    autor: 'Admin Principal', // Temporalmente hardcodeado
                    fecha: new Date().toISOString().split('T')[0],
                    texto: 'Contenido de la noticia...' // Temporalmente
                };
                break;
            }
        }

        if (noticia) {
            document.getElementById('contenidoEditarNoticia').innerHTML = `
                <input type="hidden" name="idNoticia" value="${noticia.id}">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Título de la Noticia *</label>
                            <input type="text" class="form-control" name="titulo" value="${noticia.titulo}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Fecha de Publicación</label>
                            <input type="date" class="form-control" name="fecha" value="${noticia.fecha}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">URL de la Imagen</label>
                            <input type="url" class="form-control" name="imagen" 
                                   placeholder="https://ejemplo.com/imagen.jpg">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Contenido de la Noticia *</label>
                            <textarea class="form-control" name="texto" rows="10" 
                                      placeholder="Escribe el contenido completo de la noticia..." required>${noticia.texto}</textarea>
                        </div>
                    </div>
                </div>
            `;
            new bootstrap.Modal(document.getElementById('modalEditarNoticia')).show();
        }
    }

    function eliminarNoticia(id) {
        // Encontrar el título de la noticia
        const filas = document.getElementById('tablaNoticias').getElementsByTagName('tr');
        let tituloNoticia = '';

        for (let i = 1; i < filas.length; i++) {
            const celdas = filas[i].getElementsByTagName('td');
            const idNoticia = celdas[0] ? celdas[0].textContent : celdas[1].querySelector('button').onclick.toString().match(/\d+/)[0];

            if (idNoticia == id) {
                tituloNoticia = celdas[1] ? celdas[1].querySelector('strong').textContent : celdas[0].querySelector('strong').textContent;
                break;
            }
        }

        document.getElementById('noticiaAEliminar').textContent = tituloNoticia;
        document.getElementById('idNoticiaAEliminar').value = id;
        new bootstrap.Modal(document.getElementById('modalEliminarNoticia')).show();
    }

    // Búsqueda en tiempo real
    document.getElementById('buscarNoticia').addEventListener('input', buscarNoticias);
    document.getElementById('filtroAutor').addEventListener('change', buscarNoticias);
    document.getElementById('filtroFecha').addEventListener('change', buscarNoticias);
</script>

<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }

    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }

    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }

    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }

    .text-xs {
        font-size: 0.75rem;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>