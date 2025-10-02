<div class="row">
    <div class="col-md-8 mx-auto">
        <h1 class="mb-4">Mi Perfil</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $e): ?>
                        <li><?= Core\Helpers::e($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input name="nombre" class="form-control" value="<?= Core\Helpers::e($user['nombre'] ?? '') ?>"
                        required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Apellidos</label>
                    <input name="apellidos" class="form-control"
                        value="<?= Core\Helpers::e($user['apellidos'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                        value="<?= Core\Helpers::e($user['email'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teléfono</label>
                    <input name="telefono" class="form-control" value="<?= Core\Helpers::e($user['telefono'] ?? '') ?>"
                        required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fecha de nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="form-control"
                        value="<?= Core\Helpers::e($user['fecha_nacimiento'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Dirección</label>
                    <input name="direccion" class="form-control"
                        value="<?= Core\Helpers::e($user['direccion'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sexo</label>
                    <select name="sexo" class="form-select">
                        <option value="">—</option>
                        <option value="M" <?= ($user['sexo'] ?? '') === 'M' ? 'selected' : '' ?>>Masculino</option>
                        <option value="F" <?= ($user['sexo'] ?? '') === 'F' ? 'selected' : '' ?>>Femenino</option>
                        <option value="Otro" <?= ($user['sexo'] ?? '') === 'Otro' ? 'selected' : '' ?>>Otro</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nueva contraseña (opcional)</label>
                    <input type="password" name="new_password" class="form-control"
                        placeholder="Dejar vacío para no cambiar">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
                    <a href="<?= Core\Helpers::baseUrl('/') ?>" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </form>
    </div>
</div>