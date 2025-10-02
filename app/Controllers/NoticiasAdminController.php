<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Helpers;
use Core\Validator;
use App\Models\Noticia;

class NoticiasAdminController extends Controller
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

        $noticiaModel = new Noticia();
        $noticias = $noticiaModel->allWithAuthor();

        return $this->view('noticias_admin/index', [
            'title' => 'Gestión de Noticias',
            'noticias' => $noticias
        ]);
    }

    public function store(): string
    {
        if (!$this->checkAdmin())
            return '';

        $auth = Session::get('auth');
        $errors = Validator::required($_POST, ['titulo', 'imagen', 'texto']);

        if ($errors) {
            $noticiaModel = new Noticia();
            $noticias = $noticiaModel->allWithAuthor();
            return $this->view('noticias_admin/index', [
                'title' => 'Gestión de Noticias',
                'noticias' => $noticias,
                'errors' => $errors
            ]);
        }

        $noticiaModel = new Noticia();
        $noticiaModel->create([
            'titulo' => trim($_POST['titulo']),
            'imagen' => trim($_POST['imagen']),
            'texto' => trim($_POST['texto']),
            'fecha' => date('Y-m-d'),
            'idUser' => $auth['idUser']
        ]);

        Session::set('flash', 'Noticia creada correctamente');
        $this->redirect(Helpers::baseUrl('/noticias-administracion'));
        return '';
    }

    public function update(): string
    {
        if (!$this->checkAdmin())
            return '';

        $idNoticia = (int) $_POST['idNoticia'];

        $noticiaModel = new Noticia();
        $noticiaModel->update($idNoticia, [
            'titulo' => trim($_POST['titulo']),
            'imagen' => trim($_POST['imagen']),
            'texto' => trim($_POST['texto'])
        ]);

        Session::set('flash', 'Noticia actualizada correctamente');
        $this->redirect(Helpers::baseUrl('/noticias-administracion'));
        return '';
    }

    public function delete(): string
    {
        if (!$this->checkAdmin())
            return '';

        $idNoticia = (int) $_POST['idNoticia'];

        $noticiaModel = new Noticia();
        $noticiaModel->delete($idNoticia);

        Session::set('flash', 'Noticia eliminada correctamente');
        $this->redirect(Helpers::baseUrl('/noticias-administracion'));
        return '';
    }
}