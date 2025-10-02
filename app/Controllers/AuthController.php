<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\UserData;
use App\Models\UserLogin;
use Core\Controller;
use Core\Helpers;
use Core\Session;
use Core\Validator;

class AuthController extends Controller
{
    public function showLogin(): string
    {
        return $this->view('auth/login');
    }

    public function login(): string
    {
        $errors = Validator::required($_POST, ['usuario', 'password']);
        if ($errors) {
            return $this->view('auth/login', compact('errors'));
        }

        $userLogin = new UserLogin();
        $row = $userLogin->findByUsuario(trim($_POST['usuario']));
        if (!$row || !password_verify($_POST['password'], $row['password'])) {
            $errors['credenciales'] = 'Usuario o contrasena incorrectos';
            return $this->view('auth/login', compact('errors'));
        }

        Session::set('auth', [
            'idLogin' => (int) $row['idLogin'],
            'idUser' => (int) $row['idUser'],
            'usuario' => $row['usuario'],
            'rol' => $row['rol'],
        ]);

        $this->redirect(Helpers::baseUrl('/'));
        return '';
    }

    public function showRegistro(): string
    {
        return $this->view('auth/registro');
    }

    public function register(): string
    {
        $required = ['nombre', 'apellidos', 'email', 'telefono', 'fecha_nacimiento', 'usuario', 'password'];
        $errors = Validator::required($_POST, $required);
        if ($errors) {
            return $this->view('auth/registro', compact('errors'));
        }

        $userData = new UserData();
        $userLogin = new UserLogin();

        // TODO: validar unicidad email/usuario con consultas previas

        $idUser = $userData->create([
            'nombre' => trim($_POST['nombre']),
            'apellidos' => trim($_POST['apellidos']),
            'email' => trim($_POST['email']),
            'telefono' => trim($_POST['telefono']),
            'fecha_nacimiento' => trim($_POST['fecha_nacimiento']),
            'direccion' => $_POST['direccion'] ?? null,
            'sexo' => $_POST['sexo'] ?? null,
        ]);

        $userLogin->create([
            'idUser' => $idUser,
            'usuario' => trim($_POST['usuario']),
            'email' => trim($_POST['email']),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'rol' => 'user',
        ]);

        // Mensaje y redireccion a login
        Session::set('flash', 'Registro correcto. Inicia sesion.');
        $this->redirect(Helpers::baseUrl('/login'));
        return '';
    }

    public function logout(): string
    {
        Session::forget('auth');
        $this->redirect(Helpers::baseUrl('/'));
        return '';
    }
}
