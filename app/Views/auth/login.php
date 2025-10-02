<h1 class="mb-4">Iniciar sesión</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $e): ?>
                <li><?= Core\Helpers::e($e) ?></li><?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="post">
    <?= Core\CSRF::getTokenInput() ?>
    <div class="mb-3">
        <label class="form-label">Usuario</label>
        <input name="usuario" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Contraseña</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-primary">Entrar</button>
    <a class="btn btn-link" href="<?= Core\Helpers::baseUrl('/registro') ?>">¿No tienes cuenta? Regístrate</a>
</form>