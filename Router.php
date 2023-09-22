<?php

namespace MVC;

class Router
{
    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $funcion)
    {
        $this->rutasGET[$url] = $funcion;
    }

    public function post($url, $funcion)
    {
        $this->rutasPOST[$url] = $funcion;
    }

    public function comprobarRutas()
    {
        session_start();

        $auth = $_SESSION['login'] ?? null;

        // Arreglo de rutas protegidas
        $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar'];


        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        if ($metodo === 'GET') {
            $funcion = $this->rutasGET[$urlActual] ?? null;
        } else {
            $funcion = $this->rutasPOST[$urlActual] ?? null;
        }

        // Proteger las rutas
        if (in_array($urlActual, $rutas_protegidas) && !$auth) {
            header('Location: /');
        }

        if ($funcion) {
            // La URL existe y hay una funcion asociada
            call_user_func($funcion, $this);
        } else {
            echo "Pagina no encontrada";
        }
    }
    //Muestra una vista

    public function render($view, $datos = [])
    {
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        ob_start(); // Almacenamiento en memoria
        include __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean(); // Limpia el Buffer

        include __DIR__ . "/views/layout.php";
    }
}
