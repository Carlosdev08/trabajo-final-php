<h1 class="mb-4">Registro</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $e): ?>
                <li><?= Core\Helpers::e($e) ?></li><?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="post">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nombre</label>
            <input name="nombre" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Apellidos</label>
            <input name="apellidos" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Teléfono</label>
            <input name="telefono" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Fecha de nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Dirección</label>
            <input name="direccion" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Sexo</label>
            <select name="sexo" class="form-select">
                <option value="">—</option>
                <option value="M">M</option>
                <option value="F">F</option>
                <option value="O">O</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Usuario</label>
            <input name="usuario" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-success">Crear cuenta</button>
        <a class="btn btn-link" href="<?= Core\Helpers::baseUrl('/login') ?>">¿Ya tienes cuenta? Inicia sesión</a>
    </div>
</form>