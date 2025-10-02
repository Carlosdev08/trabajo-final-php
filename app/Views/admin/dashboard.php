<!-- Dashboard Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Administrativo</h1>
    <div class="text-muted">
        <i class="fas fa-calendar"></i>
        <?= date('d/m/Y H:i') ?>
    </div>
</div>

<!-- Tarjetas de estadísticas -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Usuarios</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['totalUsers'] ?></div>
                        <div class="text-xs text-success">
                            <i class="fas fa-arrow-up"></i>
                            +<?= $stats['newUsersThisMonth'] ?> este mes
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Citas Totales</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['totalCitas'] ?></div>
                        <div class="text-xs text-warning">
                            <i class="fas fa-clock"></i>
                            <?= $stats['citasPendientes'] ?> pendientes
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Noticias Publicadas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['totalNoticias'] ?></div>
                        <div class="text-xs text-info">
                            <i class="fas fa-plus"></i>
                            +<?= $stats['noticiasThisMonth'] ?> este mes
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Tasa de Ocupación</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $stats['totalCitas'] > 0 ? round(($stats['citasPendientes'] / $stats['totalCitas']) * 100, 1) : 0 ?>%
                        </div>
                        <div class="text-xs text-muted">
                            Citas pendientes vs total
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-percentage fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos y Contenido -->
<div class="row">
    <!-- Gráfico de Citas por Mes -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Evolución de Citas - Últimos 6 Meses</h6>
            </div>
            <div class="card-body">
                <canvas id="citasChart" width="100%" height="40"></canvas>
            </div>
        </div>
    </div>

    <!-- Gráfico de Usuarios por Rol -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Distribución de Usuarios</h6>
            </div>
            <div class="card-body">
                <canvas id="rolesChart" width="100%" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Próximas Citas y Actividad Reciente -->
<div class="row">
    <!-- Próximas Citas -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-alt"></i>
                    Próximas Citas
                </h6>
            </div>
            <div class="card-body">
                <?php if (empty($upcomingCitas)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-calendar-times fa-3x mb-3"></i>
                        <p>No hay citas programadas</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Motivo</th>
                                    <th>Contacto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($upcomingCitas, 0, 5) as $cita): ?>
                                    <tr>
                                        <td>
                                            <span class="badge badge-primary">
                                                <?= date('d/m', strtotime($cita['fecha_cita'])) ?>
                                            </span>
                                        </td>
                                        <td class="font-weight-bold"><?= Core\Helpers::e($cita['usuario']) ?></td>
                                        <td class="text-muted small">
                                            <?= Core\Helpers::e(substr($cita['motivo_cita'] ?? 'Sin motivo', 0, 30)) ?>
                                        </td>
                                        <td>
                                            <a href="tel:<?= $cita['telefono'] ?>" class="text-success">
                                                <i class="fas fa-phone fa-sm"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="<?= Core\Helpers::baseUrl('/citaciones-administracion') ?>" class="btn btn-primary btn-sm">
                            Ver Todas las Citas
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Noticias en Tendencia -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-fire"></i>
                    Noticias en Tendencia
                </h6>
            </div>
            <div class="card-body">
                <?php if (!empty($recentActivity['noticias'])): ?>
                    <?php foreach (array_slice($recentActivity['noticias'], 0, 4) as $index => $noticia): ?>
                        <div class="d-flex mb-3 <?= $index < 3 ? 'border-bottom pb-3' : '' ?>">
                            <div class="position-relative me-3">
                                <div class="bg-<?= ['danger', 'warning', 'success', 'info'][$index % 4] ?> rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="fas fa-newspaper text-white fa-sm"></i>
                                </div>
                                <?php if ($index === 0): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        HOT
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 font-weight-bold text-dark">
                                    <?= Core\Helpers::e(substr($noticia['titulo'], 0, 60)) ?>...
                                </h6>
                                <p class="mb-1 text-muted small">
                                    Por <?= Core\Helpers::e($noticia['autor']) ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i>
                                        <?= date('d/m/Y', strtotime($noticia['fecha'])) ?>
                                    </small>
                                    <span class="badge bg-<?= ['danger', 'warning', 'success', 'info'][$index % 4] ?>">
                                        Tendencia #<?= $index + 1 ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="text-center mt-3">
                        <a href="<?= Core\Helpers::baseUrl('/noticias') ?>" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-newspaper"></i>
                            Ver Todas las Noticias
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-newspaper fa-3x mb-3"></i>
                        <p>No hay noticias disponibles</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Accesos Rápidos -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-tachometer-alt"></i>
                    Accesos Rápidos
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <a href="<?= Core\Helpers::baseUrl('/usuarios-administracion') ?>"
                            class="btn btn-outline-primary btn-lg w-100">
                            <i class="fas fa-users fa-2x mb-2 d-block"></i>
                            Gestionar Usuarios
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?= Core\Helpers::baseUrl('/citaciones-administracion') ?>"
                            class="btn btn-outline-success btn-lg w-100">
                            <i class="fas fa-calendar-check fa-2x mb-2 d-block"></i>
                            Gestionar Citas
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?= Core\Helpers::baseUrl('/noticias-administracion') ?>"
                            class="btn btn-outline-info btn-lg w-100">
                            <i class="fas fa-newspaper fa-2x mb-2 d-block"></i>
                            Gestionar Noticias
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?= Core\Helpers::baseUrl('/perfil') ?>" class="btn btn-outline-warning btn-lg w-100">
                            <i class="fas fa-user-cog fa-2x mb-2 d-block"></i>
                            Mi Perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para los gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de Citas por Mes
    const citasCtx = document.getElementById('citasChart').getContext('2d');
    const citasChart = new Chart(citasCtx, {
        type: 'line',
        data: {
            labels: [<?php
            $labels = [];
            foreach ($chartData['citasPorMes'] as $data) {
                $labels[] = '"' . date('M Y', strtotime($data['mes'] . '-01')) . '"';
            }
            echo implode(',', $labels);
            ?>],
            datasets: [{
                label: 'Citas',
                data: [<?php
                $values = [];
                foreach ($chartData['citasPorMes'] as $data) {
                    $values[] = $data['total'];
                }
                echo implode(',', $values);
                ?>],
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de Usuarios por Rol
    const rolesCtx = document.getElementById('rolesChart').getContext('2d');
    const rolesChart = new Chart(rolesCtx, {
        type: 'doughnut',
        data: {
            labels: [<?php
            $roleLabels = [];
            foreach ($chartData['usuariosPorRol'] as $data) {
                $roleLabels[] = '"' . ucfirst($data['rol']) . '"';
            }
            echo implode(',', $roleLabels);
            ?>],
            datasets: [{
                data: [<?php
                $roleValues = [];
                foreach ($chartData['usuariosPorRol'] as $data) {
                    $roleValues[] = $data['total'];
                }
                echo implode(',', $roleValues);
                ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 205, 86, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
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

    .avatar-sm {
        width: 2.5rem;
        height: 2.5rem;
    }

    .timeline-item {
        position: relative;
    }

    .text-xs {
        font-size: 0.75rem;
    }
</style>