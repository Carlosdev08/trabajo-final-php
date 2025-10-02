<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\Noticia;

class NoticiasController extends Controller
{
    public function index(): string
    {
        $model = new Noticia();
        $noticias = $model->allWithAuthor();
        return $this->view('noticias/index', compact('noticias'));
    }
}