<?php
session_start();

// Ruta corregida al controlador
require_once '../app/controllers/SexoController.php';

$requestUri = $_SERVER["REQUEST_URI"];
$basePath = '/eysphp/public/';
$route = str_replace($basePath, '', $requestUri);

if (strpos($route, 'index.php') === 0) {
    $route = str_replace('index.php', '', $route);
}
$route = strtok($route, '?');
$route = trim($route, '/');

$controller = new SexoController();

switch ($route) {
    case '':
    case 'sexo':
    case 'sexo/index':
        $controller->index();
        break;

    // --- RUTA NUEVA PARA MOSTRAR FORMULARIO DE CREAR ---
    case 'sexo/create':
        $controller->create();
        break;

    // --- RUTA NUEVA PARA PROCESAR EL FORMULARIO DE CREAR ---
    case 'sexo/store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->store();
        }
        break;

    case 'sexo/edit':
        if (isset($_GET['id'])) {
            $controller->edit($_GET['id']);
        } else {
            echo "Error: Falta el ID para editar.";
        }
        break;
        
    case 'sexo/eliminar':
        if (isset($_GET['id'])) {
            $controller->eliminar($_GET['id']);
        } else {
            echo "Error: Falta el ID para editar.";
        }
        break;
    
    case 'sexo/delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->delete();
        }
        break;

    case 'sexo/update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->update();
        }
        break;

    default:
        echo "Error 404: Página no encontrada. (Ruta: '$route')";
        break;
}