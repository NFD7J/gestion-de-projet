<?php 
namespace App\core;
class Router 
{
    public function routes()
    {
        $controller = (isset($_GET["controller"]) ? ucfirst(array_shift($_GET)) : "Home");
        $controller = "\\App\\controllers\\".$controller."Controller";

        $action = (isset($_GET["action"]) ? array_shift($_GET) : "index");
        if(class_exists($controller)){
            $controller = new $controller();
            if(method_exists($controller,$action)){
                (isset($_GET)) ? $controller->$action($_GET) : $controller->$action();
            }else{
                http_response_code(404);
                echo "La page recherchée n'existe pas";
            }
        }else{
            http_response_code(404);
            echo "La page recherchée n'existe pas";
        }
    }
}
?>