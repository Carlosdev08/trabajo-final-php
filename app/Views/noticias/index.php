<h1 class="mb-4">Noticias</h1>
<?php if (empty($noticias)): ?>
    <div class="alert alert-info">No hay noticias.</div>
<?php else: ?>
    <div class="row g-3">
        <?php foreach ($noticias as $n): ?>
            <div class="col-md-6">
                <div class="card h-100">
                    <img src="<?= Core\Helpers::e($n['imagen']) ?>" class="card-img-top" alt="imagen noticia">
                    <div class="card-body">
                        <h5 class="card-title"><?= Core\Helpers::e($n['titulo']) ?></h5>
                        <p class="card-text small text-muted">Publicado el <?= Core\Helpers::e($n['fecha']) ?> · por
                            <?= Core\Helpers::e(($n['nombre'] ?? '') . ' ' . ($n['apellidos'] ?? '')) ?></p>
                        <p class="card-text"><?= nl2br(Core\Helpers::e($n['texto'])) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>