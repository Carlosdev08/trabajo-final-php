<?php
namespace App\Controllers;


use Core\Controller;


class HomeController extends Controller
{
    public function index(): string
    {
        return $this->view('home/index', [
            'title' => 'Bienvenido/a',
        ]);
    }
}