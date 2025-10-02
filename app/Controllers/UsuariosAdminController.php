<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Helpers;
use Core\Validator;
use App\Models\UserData;
use App\Models\UserLogin;

class UsuariosAdminController extends Controller
{
    private function checkAdmin(): bool
    {
        $auth = Session::get('auth');
        if (!$auth || $auth['rol'] !== 'admin') {
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

        $required = ['nombre', 'apellidos', 'email', 'telefono', 'fecha_nacimiento', 'usuario', 'password'];
        $errors = Validator::required($_POST, $required);

        if ($errors) {
            $userModel = new UserData();
            $usuarios = $userModel->getAll();
            return $this->view('admin/usuarios', compact('errors', 'usuarios'));
        }

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
        $userLoginModel = new UserLogin();
        $userLoginModel->create([
            'idUser' => $idUser,
            'usuario' => trim($_POST['usuario']),
            'email' => trim($_POST['email']),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'rol' => $_POST['rol'] ?? 'user',
        ]);

        Session::set('flash', 'Usuario creado correctamente');
        $this->redirect(Helpers::baseUrl('/usuarios-administracion'));
        return '';
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