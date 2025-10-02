<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Helpers;
use Core\Validator;
use App\Models\Cita;
use App\Models\UserData;
use App\Models\UserLogin;

class CitacionesAdminController extends Controller
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

        $citaModel = new Cita();
        $userDataModel = new UserData();

        // Obtener citas con datos de usuario
        $citas = $citaModel->getAllWithUser();
        $usuarios = $userDataModel->getAll();

        return $this->view('citaciones_admin/index', [
            'title' => 'Gestión de Citas',
            'citas' => $citas,
            'usuarios' => $usuarios
        ]);
    }

    public function store(): string
    {
        if (!$this->checkAdmin())
            return '';

        $errors = Validator::required($_POST, ['idUser', 'fecha_cita']);

        if ($errors) {
            $citaModel = new Cita();
            $citas = $citaModel->getAllWithUser();
            $userModel = new UserData();
            $usuarios = $userModel->getAll();
            return $this->view('admin/citas', compact('errors', 'citas', 'usuarios'));
        }

        $citaModel = new Cita();
        $citaModel->create([
            'idUser' => (int) $_POST['idUser'],
            'fecha_cita' => $_POST['fecha_cita'],
            'motivo_cita' => $_POST['motivo_cita'] ?? null
        ]);

        Session::set('flash', 'Cita creada correctamente');
        $this->redirect(Helpers::baseUrl('/citaciones-administracion'));
        return '';
    }

    public function update(): string
    {
        if (!$this->checkAdmin())
            return '';

        $idCita = (int) $_POST['idCita'];

        $citaModel = new Cita();
        $citaModel->update($idCita, [
            'fecha_cita' => $_POST['fecha_cita'],
            'motivo_cita' => $_POST['motivo_cita'] ?? null
        ]);

        Session::set('flash', 'Cita actualizada correctamente');
        $this->redirect(Helpers::baseUrl('/citaciones-administracion'));
        return '';
    }

    public function delete(): string
    {
        if (!$this->checkAdmin())
            return '';

        $idCita = (int) $_POST['idCita'];

        $citaModel = new Cita();
        $citaModel->delete($idCita);

        Session::set('flash', 'Cita eliminada correctamente');
        $this->redirect(Helpers::baseUrl('/citaciones-administracion'));
        return '';
    }
}