<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Helpers;
use App\Models\UserData;
use App\Models\UserLogin;

class PerfilController extends Controller
{
    public function show(): string
    {
        $auth = Session::get('auth');
        if (!$auth || ($auth['rol'] !== 'user' && $auth['rol'] !== 'admin')) {
            $this->redirect(Helpers::baseUrl('/login'));
            return '';
        }

        $userModel = new UserData();
        $user = $userModel->findById($auth['idUser']);

        return $this->view('perfil/show', [
            'title' => 'Mi Perfil',
            'user' => $user
        ]);
    }

    public function update(): string
    {
        $auth = Session::get('auth');
        if (!$auth || ($auth['rol'] !== 'user' && $auth['rol'] !== 'admin')) {
            $this->redirect(Helpers::baseUrl('/login'));
            return '';
        }

        // Validación básica
        $required = ['nombre', 'apellidos', 'email', 'telefono', 'fecha_nacimiento'];
        $errors = [];

        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $errors[] = "El campo {$field} es obligatorio";
            }
        }

        if ($errors) {
            $userModel = new UserData();
            $user = $userModel->findById($auth['idUser']);
            return $this->view('perfil/show', compact('errors', 'user'));
        }

        // Actualizar datos
        $userModel = new UserData();
        $success = $userModel->update($auth['idUser'], [
            'nombre' => trim($_POST['nombre']),
            'apellidos' => trim($_POST['apellidos']),
            'email' => trim($_POST['email']),
            'telefono' => trim($_POST['telefono']),
            'fecha_nacimiento' => $_POST['fecha_nacimiento'],
            'direccion' => $_POST['direccion'] ?? null,
            'sexo' => $_POST['sexo'] ?? null,
        ]);

        // Si se proporcionó nueva contraseña
        if (!empty($_POST['new_password'])) {
            $userLoginModel = new UserLogin();
            $userLoginModel->updatePassword($auth['idLogin'], $_POST['new_password']);
        }

        Session::set('flash', 'Perfil actualizado correctamente');
        $this->redirect(Helpers::baseUrl('/perfil'));
        return '';
    }
}