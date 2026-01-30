<?php
namespace App\controllers;

abstract class Controller
{
    public function render(string $path,array $data = [])
    {
        extract($data);
        ob_start();
        include dirname(__DIR__).'/views/'.$path.'.php';
        $content = ob_get_clean();
        include dirname(__DIR__).'/views/base.php';
    }
}