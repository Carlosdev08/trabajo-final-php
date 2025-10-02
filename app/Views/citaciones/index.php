<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Mis Citaciones</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $e): ?>
                        <li><?= Core\Helpers::e($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Formulario para nueva cita -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Solicitar Nueva Cita</h5>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Fecha de la cita</label>
                            <input type="date" name="fecha_cita" class="form-control" min="<?= date('Y-m-d') ?>"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Motivo de la cita</label>
                            <input name="motivo_cita" class="form-control" placeholder="Describe el motivo de tu cita">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Solicitar Cita</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de citas -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Mis Citas</h5>
            </div>
            <div class="card-body">
                <?php if (empty($citas)): ?>
                    <div class="alert alert-info">
                        <p class="mb-0">No tienes citas programadas.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Motivo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($citas as $cita): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($cita['fecha_cita'])) ?></td>
                                        <td><?= Core\Helpers::e($cita['motivo_cita'] ?? 'Sin motivo especificado') ?></td>
                                        <td>
                                            <?php if ($cita['fecha_cita'] >= date('Y-m-d')): ?>
                                                <span class="badge bg-success">Pendiente</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Realizada</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($cita['fecha_cita'] >= date('Y-m-d')): ?>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editModal<?= $cita['idCita'] ?>">
                                                    Editar
                                                </button>
                                                <form method="post" action="<?= Core\Helpers::baseUrl('/citaciones/delete') ?>"
                                                    class="d-inline"
                                                    onsubmit="return confirm('¿Estás seguro de eliminar esta cita?')">
                                                    <input type="hidden" name="idCita" value="<?= $cita['idCita'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted">No modificable</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modales para editar citas -->
<?php foreach ($citas as $cita): ?>
    <?php if ($cita['fecha_cita'] >= date('Y-m-d')): ?>
        <div class="modal fade" id="editModal<?= $cita['idCita'] ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Cita</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post" action="<?= Core\Helpers::baseUrl('/citaciones/update') ?>">
                        <div class="modal-body">
                            <input type="hidden" name="idCita" value="<?= $cita['idCita'] ?>">
                            <div class="mb-3">
                                <label class="form-label">Fecha de la cita</label>
                                <input type="date" name="fecha_cita" class="form-control" value="<?= $cita['fecha_cita'] ?>"
                                    min="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Motivo de la cita</label>
                                <input name="motivo_cita" class="form-control"
                                    value="<?= Core\Helpers::e($cita['motivo_cita'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>