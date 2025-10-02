<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\UserData;
use App\Models\UserLogin;
use Core\Controller;
use Core\CSRF;
use Core\Helpers;
use Core\RateLimit;
use Core\SecurityLogger;
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
        // Rate limiting para login
        if (!RateLimit::check('login', 5, 300)) {
            $remainingTime = RateLimit::getRemainingTime('login', 300);
            $errors['rate_limit'] = "Demasiados intentos. Intenta de nuevo en " . ceil($remainingTime / 60) . " minutos.";
            return $this->view('auth/login', compact('errors'));
        }

        // Validar CSRF
        if (!CSRF::validateToken()) {
            SecurityLogger::logCSRFFailure();
            $errors['csrf'] = 'Token de seguridad inválido. Recarga la página.';
            return $this->view('auth/login', compact('errors'));
        }

        $errors = Validator::required($_POST, ['usuario', 'password']);
        if ($errors) {
            return $this->view('auth/login', compact('errors'));
        }

        $userLogin = new UserLogin();
        $username = trim($_POST['usuario']);
        $row = $userLogin->findByUsuario($username);
        
        if (!$row || !password_verify($_POST['password'], $row['password'])) {
            RateLimit::record('login');
            SecurityLogger::logLoginAttempt($username, false);
            $errors['credenciales'] = 'Usuario o contrasena incorrectos';
            return $this->view('auth/login', compact('errors'));
        }

        // Login exitoso
        RateLimit::reset('login');
        SecurityLogger::logLoginAttempt($username, true);

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
        // Validar CSRF
        if (!CSRF::validateToken()) {
            SecurityLogger::logCSRFFailure();
            $errors['csrf'] = 'Token de seguridad inválido. Recarga la página.';
            return $this->view('auth/registro', compact('errors'));
        }

        // Rate limiting para registro
        if (!RateLimit::check('register', 3, 600)) {
            $remainingTime = RateLimit::getRemainingTime('register', 600);
            $errors['rate_limit'] = "Demasiados registros. Intenta de nuevo en " . ceil($remainingTime / 60) . " minutos.";
            return $this->view('auth/registro', compact('errors'));
        }

        // Usar la nueva validación mejorada
        $errors = Validator::validateRegistration($_POST);
        if ($errors) {
            return $this->view('auth/registro', compact('errors'));
        }

        $userData = new UserData();
        $userLogin = new UserLogin();

        // Verificar unicidad del usuario y email
        $existingUser = $userLogin->findByUsuario(trim($_POST['usuario']));
        if ($existingUser) {
            $errors['usuario'] = 'Este nombre de usuario ya está en uso';
            return $this->view('auth/registro', compact('errors'));
        }

        $existingEmail = $userLogin->findByEmail(trim($_POST['email']));
        if ($existingEmail) {
            $errors['email'] = 'Este email ya está registrado';
            return $this->view('auth/registro', compact('errors'));
        }

        try {
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

            RateLimit::record('register');
            SecurityLogger::logUserCreation(trim($_POST['usuario']), 'user');

            // Mensaje y redireccion a login
            Session::set('flash', 'Registro correcto. Inicia sesion.');
            $this->redirect(Helpers::baseUrl('/login'));
            return '';
            
        } catch (\Exception $e) {
            SecurityLogger::logError('Error durante el registro: ' . $e->getMessage());
            $errors['general'] = 'Error interno. Inténtalo de nuevo.';
            return $this->view('auth/registro', compact('errors'));
        }
    }

    public function logout(): string
    {
        Session::forget('auth');
        $this->redirect(Helpers::baseUrl('/'));
        return '';
    }
}
