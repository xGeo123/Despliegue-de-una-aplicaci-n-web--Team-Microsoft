<?php
session_start();

// --- CONTROLADORES ---
// Incluir todos los controladores necesarios
require_once '../app/controllers/PersonaController.php';
require_once '../app/controllers/SexoController.php';
require_once '../app/controllers/DireccionController.php';
require_once '../app/controllers/TelefonoController.php';
require_once '../app/controllers/EstadocivilController.php';

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

        // --- RUTAS DE PERSONA ---
        case 'persona':
        case 'persona/index':
            $controller = new PersonaController();
            $controller->index();
            break;
        case 'persona/create':
            $controller = new PersonaController();
            $controller->createForm(); // Asumo que createForm muestra el formulario
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
        case 'persona/view':
            if (isset($_GET['idpersona'])) {
                $controller = new PersonaController();
                $controller->registro($_GET['idpersona']); // Asumo que 'registro' es para ver
            } else {
                echo "Error: Falta el ID de persona para ver.";
            }
            break;

        // --- RUTAS DE SEXO (Fusionadas) ---
        case 'sexo':
        case 'sexo/index':
            $controller = new SexoController();
            $controller->index();
            break;
        // Ruta de 'create' (del archivo 1)
        case 'sexo/create':
            $controller = new SexoController();
            $controller->create(); // Asumo que 'create' muestra el formulario
            break;
        // Ruta de 'store' (del archivo 1)
        case 'sexo/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new SexoController();
                $controller->store();
            }
            break;
        case 'sexo/edit':
            if (isset($_GET['idsexo'])) { // Corregido a 'idsexo' según el archivo 2
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
        case 'sexo/eliminar': // Formulario de confirmación
            if (isset($_GET['idsexo'])) { // Corregido a 'idsexo'
                $controller = new SexoController();
                $controller->eliminar($_GET['idsexo']);
            } else {
                echo "Error: Falta el ID de sexo para eliminar.";
            }
            break;
        case 'sexo/delete': // Acción de borrado
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new SexoController();
                $controller->delete();
            }
            break;

        // --- RUTAS DE DIRECCION ---
        case 'direccion':
        case 'direccion/index':
            $controller = new DireccionController();
            $controller->index();
            break;
        case 'direccion/create':
            $controller = new DireccionController();
            $controller->createForm();
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

        // --- RUTAS DE TELEFONO ---
        case 'telefono':
        case 'telefono/index':
            $controller = new TelefonoController();
            $controller->index();
            break;
        case 'telefono/create':
            $controller = new TelefonoController();
            $controller->createForm();
            break;
        case 'telefono/edit':
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

        // --- RUTAS DE ESTADO CIVIL ---
        case 'estadocivil':
        case 'estadocivil/index':
            $controller = new EstadoCivilController();
            $controller->index();
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
