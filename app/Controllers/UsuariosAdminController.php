<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Helpers;
use Core\Validator;
use Core\CSRF;
use Core\SecurityLogger;
use App\Models\UserData;
use App\Models\UserLogin;

class UsuariosAdminController extends Controller
{
    private function checkAdmin(): bool
    {
        $auth = Session::get('auth');
        if (!$auth || $auth['rol'] !== 'admin') {
            SecurityLogger::logSecurity('Intento de acceso no autorizado a admin panel');
            $this->redirect(Helpers::baseUrl('/login'));
            return false;
        }
        return true;
    }

    public function index(): string
    {
        if (!$this->checkAdmin())
            return '';

        // Obtener todos los usuarios con sus datos personales
        $userLoginModel = new UserLogin();
        $userDataModel = new UserData();

        $usuarios = $userLoginModel->getUsersWithData();

        return $this->view('usuarios_admin/index', [
            'title' => 'Gestión de Usuarios',
            'usuarios' => $usuarios,
            'pageStyles' => ['css/admin-styles.css'],
            'pageScripts' => ['js/usuarios-admin.js']
        ]);
    }

    public function store(): string
    {
        if (!$this->checkAdmin())
            return '';

        // Validar CSRF
        if (!CSRF::validateToken()) {
            SecurityLogger::logCSRFFailure();
            return json_encode(['success' => false, 'error' => 'Token de seguridad inválido']);
        }

        // Usar la nueva validación mejorada
        $errors = Validator::validateUserCreation($_POST);

        if ($errors) {
            return json_encode(['success' => false, 'errors' => $errors]);
        }

        $userLoginModel = new UserLogin();
        
        // Verificar unicidad del usuario y email
        $existingUser = $userLoginModel->findByUsuario(trim($_POST['usuario']));
        if ($existingUser) {
            return json_encode(['success' => false, 'errors' => ['usuario' => 'Este nombre de usuario ya está en uso']]);
        }

        $existingEmail = $userLoginModel->findByEmail(trim($_POST['email']));
        if ($existingEmail) {
            return json_encode(['success' => false, 'errors' => ['email' => 'Este email ya está registrado']]);
        }

        try {
            // Crear usuario
            $userDataModel = new UserData();
            $idUser = $userDataModel->create([
                'nombre' => trim($_POST['nombre']),
                'apellidos' => trim($_POST['apellidos']),
                'email' => trim($_POST['email']),
                'telefono' => trim($_POST['telefono']),
                'fecha_nacimiento' => $_POST['fecha_nacimiento'],
                'direccion' => $_POST['direccion'] ?? null,
                'sexo' => $_POST['sexo'] ?? null,
            ]);

            // Crear login
            $userLoginModel->create([
                'idUser' => $idUser,
                'usuario' => trim($_POST['usuario']),
                'email' => trim($_POST['email']),
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'rol' => $_POST['rol'] ?? 'user',
            ]);

            SecurityLogger::logUserCreation(trim($_POST['usuario']), $_POST['rol'] ?? 'user');
            return json_encode(['success' => true, 'message' => 'Usuario creado correctamente']);
            
        } catch (\Exception $e) {
            SecurityLogger::logError('Error creando usuario: ' . $e->getMessage());
            return json_encode(['success' => false, 'error' => 'Error interno. Inténtalo de nuevo.']);
        }
    }

    public function update(): string
    {
        if (!$this->checkAdmin())
            return '';

        $idUser = (int) $_POST['idUser'];

        // Actualizar datos personales
        $userDataModel = new UserData();
        $userDataModel->update($idUser, [
            'nombre' => trim($_POST['nombre']),
            'apellidos' => trim($_POST['apellidos']),
            'email' => trim($_POST['email']),
            'telefono' => trim($_POST['telefono']),
            'fecha_nacimiento' => $_POST['fecha_nacimiento'],
            'direccion' => $_POST['direccion'] ?? null,
            'sexo' => $_POST['sexo'] ?? null,
        ]);

        // Actualizar login si se proporcionó
        if (!empty($_POST['idLogin'])) {
            $userLoginModel = new UserLogin();
            $userLoginModel->update((int) $_POST['idLogin'], [
                'usuario' => trim($_POST['usuario']),
                'email' => trim($_POST['email']),
                'rol' => $_POST['rol'] ?? 'user',
            ]);

            // Cambiar contraseña si se proporcionó
            if (!empty($_POST['new_password'])) {
                $userLoginModel->updatePassword((int) $_POST['idLogin'], $_POST['new_password']);
            }
        }

        Session::set('flash', 'Usuario actualizado correctamente');
        $this->redirect(Helpers::baseUrl('/usuarios-administracion'));
        return '';
    }

    public function delete(): string
    {
        if (!$this->checkAdmin())
            return '';

        $idUser = (int) $_POST['idUser'];

        $userModel = new UserData();
        $userModel->delete($idUser);

        Session::set('flash', 'Usuario eliminado correctamente');
        $this->redirect(Helpers::baseUrl('/usuarios-administracion'));
        return '';
    }
}