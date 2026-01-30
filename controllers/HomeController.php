<?php
namespace App\controllers;

class HomeController extends Controller
{
    public function index()
    {
        $this->render('home/index');
    }
}
