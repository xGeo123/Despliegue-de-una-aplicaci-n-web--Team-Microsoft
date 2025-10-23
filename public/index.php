<?php
session_start();

// --- CONTROLADORES ---
// Rutas corregidas usando __DIR__ para construir una ruta absoluta y robusta.
// __DIR__ es el directorio del archivo actual (asumiendo 'routes/web.php' o similar)
// Si este archivo está en 'public/index.php', la ruta debe ser 'app/controllers/...'
// Asumiré que este archivo está en 'public/' basado en la estructura de 'apple6b/public/'
require_once __DIR__ . '/../app/controllers/PersonaController.php';
require_once __DIR__ . '/../app/controllers/SexoController.php';
require_once __DIR__ . '/../app/controllers/DireccionController.php';
require_once __DIR__ . '/../app/controllers/TelefonoController.php';
require_once __DIR__ . '/../app/controllers/EstadocivilController.php';

// --- ANÁLISIS DE RUTA ---
$requestUri = $_SERVER["REQUEST_URI"];
// Asegúrate de que este sea el basePath correcto para tu proyecto
$basePath = '/apple6b/public/'; 

// Remover el prefijo basePath
$route = str_replace($basePath, '', $requestUri);

// Limpiar la ruta (lógica mejorada del primer archivo)
if (strpos($route, 'index.php') === 0) {
    $route = str_replace('index.php', '', $route);
}
$route = strtok($route, '?'); // Quitar parámetros GET
$route = trim($route, '/'); // Quitar slashes al inicio y final

// --- MENÚ PRINCIPAL ---
// Mostrar el menú si no se ha solicitado ninguna acción específica
if (empty($route) || $route === '/') {
    echo "<h1>Menú de Tablas</h1>";
    echo "<ul>";
    echo "<li><a href='" . $basePath . "persona/index'>Personas</a></li>";
    echo "<li><a href='" . $basePath . "sexo/index'>Sexos</a></li>";
    echo "<li><a href='" . $basePath . "direccion/index'>Direcciones</a></li>";
    echo "<li><a href='" . $basePath . "telefono/index'>Teléfonos</a></li>";
    echo "<li><a href='" . $basePath . "estadocivil/index'>Estados Civiles</a></li>";
    echo "</ul>";
} else {
    // --- ENRUTADOR PRINCIPAL ---
    switch ($route) {

        // --- RUTAS DE PERSONA (CRUD Completo) ---
        case 'persona':
        case 'persona/index':
            $controller = new PersonaController();
            $controller->index();
            break;
        case 'persona/create': // Muestra formulario
            $controller = new PersonaController();
            $controller->create(); // Método estandarizado
            break;
        case 'persona/store': // Procesa formulario
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new PersonaController();
                $controller->store();
            }
            break;
        case 'persona/edit':
            if (isset($_GET['idpersona'])) {
                $controller = new PersonaController();
                $controller->edit($_GET['idpersona']);
            } else {
                echo "Error: Falta el ID de persona para editar.";
            }
            break;
        case 'persona/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new PersonaController();
                $controller->update();
            }
            break;
        case 'persona/eliminar': // Muestra confirmación
             if (isset($_GET['idpersona'])) {
                $controller = new PersonaController();
                $controller->eliminar($_GET['idpersona']);
            } else {
                echo "Error: Falta el ID de persona para eliminar.";
            }
            break;
        case 'persona/delete': // Procesa borrado
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new PersonaController();
                $controller->delete();
            }
            break;
        case 'persona/view': // Vista de registro
            if (isset($_GET['idpersona'])) {
                $controller = new PersonaController();
                $controller->registro($_GET['idpersona']);
            } else {
                echo "Error: Falta el ID de persona para ver.";
            }
            break;

        // --- RUTAS DE SEXO (CRUD Completo) ---
        case 'sexo':
        case 'sexo/index':
            $controller = new SexoController();
            $controller->index();
            break;
        case 'sexo/create':
            $controller = new SexoController();
            $controller->create();
            break;
        case 'sexo/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new SexoController();
                $controller->store();
            }
            break;
        case 'sexo/edit':
            if (isset($_GET['idsexo'])) { 
                $controller = new SexoController();
                $controller->edit($_GET['idsexo']);
            } else {
                echo "Error: Falta el ID de sexo para editar.";
            }
            break;
        case 'sexo/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new SexoController();
                $controller->update();
            }
            break;
        case 'sexo/eliminar': 
            if (isset($_GET['idsexo'])) { 
                $controller = new SexoController();
                $controller->eliminar($_GET['idsexo']);
            } else {
                echo "Error: Falta el ID de sexo para eliminar.";
            }
            break;
        case 'sexo/delete': 
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new SexoController();
                $controller->delete();
            }
            break;

        // --- RUTAS DE DIRECCION (CRUD Completo) ---
        case 'direccion':
        case 'direccion/index':
            $controller = new DireccionController();
            $controller->index();
            break;
        case 'direccion/create':
            $controller = new DireccionController();
            $controller->create(); // Estandarizado
            break;
        case 'direccion/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new DireccionController();
                $controller->store();
            }
            break;
        case 'direccion/edit':
            if (isset($_GET['iddireccion'])) {
                $controller = new DireccionController();
                $controller->edit($_GET['iddireccion']);
            } else {
                echo "Error: Falta el ID de dirección para editar.";
            }
            break;
        case 'direccion/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new DireccionController();
                $controller->update();
            }
            break;
        case 'direccion/eliminar':
            if (isset($_GET['iddireccion'])) {
                $controller = new DireccionController();
                $controller->eliminar($_GET['iddireccion']);
            } else {
                echo "Error: Falta el ID de dirección para eliminar.";
            }
            break;
        case 'direccion/delete':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new DireccionController();
                $controller->delete();
            }
            break;

        // --- RUTAS DE TELEFONO (CRUD Completo) ---
        case 'telefono':
        case 'telefono/index':
            $controller = new TelefonoController();
            $controller->index();
            break;
        case 'telefono/create':
            $controller = new TelefonoController();
            $controller->create(); // Estandarizado
            break;
        case 'telefono/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new TelefonoController();
                $controller->store();
            }
            break;
        case 'telefono/edit':
            // CAMBIO: Ahora buscamos 'idtelefono' para que coincida con la BD y el Controller.
            if (isset($_GET['idtelefono'])) { 
                $controller = new TelefonoController();
                $controller->edit($_GET['idtelefono']);
            } else {
                echo "Error: Falta el ID de teléfono para editar.";
            }
            break;
        case 'telefono/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new TelefonoController();
                $controller->update();
            }
            break;
        case 'telefono/eliminar':
             // CAMBIO: Ahora buscamos 'idtelefono' para que coincida con la BD y el Controller.
             if (isset($_GET['idtelefono'])) {
                $controller = new TelefonoController();
                $controller->eliminar($_GET['idtelefono']);
            } else {
                echo "Error: Falta el ID de teléfono para eliminar.";
            }
            break;
        case 'telefono/delete':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new TelefonoController();
                $controller->delete();
            }
            break;

        // --- RUTAS DE ESTADO CIVIL (CRUD Completo) ---
        case 'estadocivil':
        case 'estadocivil/index':
            $controller = new EstadocivilController();
            $controller->index();
            break;
        case 'estadocivil/create':
            $controller = new EstadocivilController();
            $controller->create();
            break;
        case 'estadocivil/store':
             if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new EstadocivilController();
                $controller->store();
            }
            break;
        case 'estadocivil/edit':
            if (isset($_GET['idestadocivil'])) {
                $controller = new EstadocivilController();
                $controller->edit($_GET['idestadocivil']);
            } else {
                echo "Error: Falta el ID de estado civil para editar.";
            }
            break;
        case 'estadocivil/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new EstadocivilController();
                $controller->update();
            }
            break;
        case 'estadocivil/eliminar':
            if (isset($_GET['idestadocivil'])) {
                $controller = new EstadocivilController();
                $controller->eliminar($_GET['idestadocivil']);
            } else {
                echo "Error: Falta el ID de estado civil para eliminar.";
            }
            break;
        case 'estadocivil/delete':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new EstadocivilController();
                $controller->delete();
            }
            break;

        // --- RUTA DEFAULT ---
        default:
            echo "Error 404: Página no encontrada. (Ruta: '$route')";
            break;
    }
}
?>

