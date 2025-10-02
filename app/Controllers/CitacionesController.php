<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Helpers;
use Core\Validator;
use App\Models\Cita;

class CitacionesController extends Controller
{
    public function index(): string
    {
        $auth = Session::get('auth');
        if (!$auth || $auth['rol'] !== 'user') {
            $this->redirect(Helpers::baseUrl('/login'));
            return '';
        }

        $citaModel = new Cita();
        $citas = $citaModel->getAllByUser($auth['idUser']);

        return $this->view('citaciones/index', [
            'title' => 'Mis Citaciones',
            'citas' => $citas
        ]);
    }

    public function store(): string
    {
        $auth = Session::get('auth');
        if (!$auth || $auth['rol'] !== 'user') {
            $this->redirect(Helpers::baseUrl('/login'));
            return '';
        }

        $errors = Validator::required($_POST, ['fecha_cita']);
        if ($errors) {
            $citaModel = new Cita();
            $citas = $citaModel->getAllByUser($auth['idUser']);
            return $this->view('citaciones/index', compact('errors', 'citas'));
        }

        // Validar que la fecha sea futura
        if ($_POST['fecha_cita'] < date('Y-m-d')) {
            $errors['fecha_cita'] = 'La fecha de la cita debe ser futura';
            $citaModel = new Cita();
            $citas = $citaModel->getAllByUser($auth['idUser']);
            return $this->view('citaciones/index', compact('errors', 'citas'));
        }

        $citaModel = new Cita();
        $citaModel->create([
            'idUser' => $auth['idUser'],
            'fecha_cita' => $_POST['fecha_cita'],
            'motivo_cita' => $_POST['motivo_cita'] ?? null
        ]);

        Session::set('flash', 'Cita solicitada correctamente');
        $this->redirect(Helpers::baseUrl('/citaciones'));
        return '';
    }

    public function update(): string
    {
        $auth = Session::get('auth');
        if (!$auth || $auth['rol'] !== 'user') {
            $this->redirect(Helpers::baseUrl('/login'));
            return '';
        }

        $idCita = (int) $_POST['idCita'];
        $citaModel = new Cita();

        // Verificar que puede modificar (fecha futura y es suya)
        if (!$citaModel->canModify($idCita, $auth['idUser'])) {
            Session::set('flash', 'No puedes modificar esta cita');
            $this->redirect(Helpers::baseUrl('/citaciones'));
            return '';
        }

        $citaModel->update($idCita, [
            'fecha_cita' => $_POST['fecha_cita'],
            'motivo_cita' => $_POST['motivo_cita'] ?? null
        ]);

        Session::set('flash', 'Cita actualizada correctamente');
        $this->redirect(Helpers::baseUrl('/citaciones'));
        return '';
    }

    public function delete(): string
    {
        $auth = Session::get('auth');
        if (!$auth || $auth['rol'] !== 'user') {
            $this->redirect(Helpers::baseUrl('/login'));
            return '';
        }

        $idCita = (int) $_POST['idCita'];
        $citaModel = new Cita();

        // Verificar que puede modificar
        if (!$citaModel->canModify($idCita, $auth['idUser'])) {
            Session::set('flash', 'No puedes eliminar esta cita');
            $this->redirect(Helpers::baseUrl('/citaciones'));
            return '';
        }

        $citaModel->delete($idCita);

        Session::set('flash', 'Cita eliminada correctamente');
        $this->redirect(Helpers::baseUrl('/citaciones'));
        return '';
    }
}