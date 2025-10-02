<?php
namespace App\Controllers;

use Core\Controller;
use Core\CSRF;
use Core\Helpers;
use Core\SecurityLogger;
use Core\Session;
use Core\Validator;
use App\Models\UserData;

class ServiciosController extends Controller
{
    public function index(): string
    {
        return $this->view('servicios/index', [
            'title' => 'Nuestros Servicios',
            'pageStyles' => ['css/servicios.css']
        ]);
    }

    public function desarrolloWeb(): string
    {
        return $this->view('servicios/desarrollo-web', [
            'title' => 'Desarrollo Web',
            'pageStyles' => ['css/servicios.css']
        ]);
    }

    public function baseDatos(): string
    {
        return $this->view('servicios/base-datos', [
            'title' => 'Base de Datos',
            'pageStyles' => ['css/servicios.css']
        ]);
    }

    public function appsMoviles(): string
    {
        return $this->view('servicios/apps-moviles', [
            'title' => 'Apps Móviles',
            'pageStyles' => ['css/servicios.css']
        ]);
    }

    public function consultoria(): string
    {
        return $this->view('servicios/consultoria', [
            'title' => 'Consultoría Tecnológica',
            'pageStyles' => ['css/servicios.css']
        ]);
    }

    public function showContacto(): string
    {
        return $this->view('servicios/contacto', [
            'title' => 'Contactar - Solicitar Presupuesto',
            'pageStyles' => ['css/servicios.css']
        ]);
    }

    public function procesarContacto(): string
    {
        // Validar CSRF
        if (!CSRF::validateToken()) {
            SecurityLogger::logCSRFFailure();
            $errors['csrf'] = 'Token de seguridad inválido. Recarga la página.';
            return $this->view('servicios/contacto', compact('errors'));
        }

        // Validar datos
        $errors = Validator::required($_POST, ['nombre', 'email', 'telefono', 'servicio', 'mensaje']);
        
        // Validar email
        if (isset($_POST['email']) && !empty($_POST['email']) && !Validator::email($_POST['email'])) {
            $errors['email'] = 'El formato del email no es válido';
        }

        if ($errors) {
            return $this->view('servicios/contacto', compact('errors'));
        }

        // Aquí podrías guardar en BD o enviar email
        // Por ahora solo logueamos el contacto
        SecurityLogger::logInfo('Nueva consulta de servicio', [
            'nombre' => $_POST['nombre'],
            'email' => $_POST['email'],
            'servicio' => $_POST['servicio']
        ]);

        Session::set('flash', '¡Gracias por tu consulta! Te contactaremos pronto.');
        $this->redirect(Helpers::baseUrl('/servicios/contacto'));
        return '';
    }
}