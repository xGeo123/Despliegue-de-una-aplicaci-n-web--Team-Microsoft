<?php
session_start();

// --- CONTROLADORES ---
require_once __DIR__ . '/../app/controllers/PersonaController.php';
require_once __DIR__ . '/../app/controllers/SexoController.php';
require_once __DIR__ . '/../app/controllers/DireccionController.php';
require_once __DIR__ . '/../app/controllers/TelefonoController.php';
require_once __DIR__ . '/../app/controllers/EstadocivilController.php';

// --- ANÁLISIS DE RUTA ---
$requestUri = $_SERVER["REQUEST_URI"];
$basePath = '/public/'; 

// Obtener la ruta relativa al basePath
$route = '';
if (strpos($requestUri, $basePath) === 0) {
    $route = substr($requestUri, strlen($basePath));
}

// Limpiar la ruta
$route = strtok($route, '?'); // Quitar parámetros GET
$route = trim($route, '/'); // Quitar slashes al inicio y final

// --- MENÚ PRINCIPAL ---
// Si después de limpiar, la ruta está vacía, mostrar menú
if (empty($route)) { 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <!-- Incluir CSS principal -->
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
    <style>
        /* Estilos específicos para el menú principal */
        body {
            font-family: Arial, sans-serif; /* Fuente consistente */
            background-color: #f4f6f8;
            padding-top: 40px;
        }
        .container {
             /* Usar estilos del CSS si existen, o estos básicos */
            max-width: 600px; 
            margin: auto;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .container h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .menu-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .menu-list li {
            margin-bottom: 15px; /* Espacio entre botones */
        }
        .menu-list a {
            display: block; /* Hacer que el enlace ocupe todo el li */
            padding: 12px 20px;
            background-color: #007BFF; /* Azul similar al botón 'Agregar' */
            color: white;
            text-decoration: none;
            border-radius: 8px; /* Bordes redondeados */
            text-align: center;
            font-size: 16px;
            transition: background-color 0.2s ease; /* Transición suave */
        }
        .menu-list a:hover {
            background-color: #0056b3; /* Azul más oscuro al pasar el ratón */
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Menú de Tablas</h1>
        <ul class="menu-list">
            <li><a href='<?php echo $basePath; ?>persona/index'>Personas</a></li>
            <li><a href='<?php echo $basePath; ?>sexo/index'>Sexos</a></li>
            <li><a href='<?php echo $basePath; ?>direccion/index'>Direcciones</a></li>
            <li><a href='<?php echo $basePath; ?>telefono/index'>Teléfonos</a></li>
            <li><a href='<?php echo $basePath; ?>estadocivil/index'>Estados Civiles</a></li>
        </ul>
    </div>
</body>
</html>
<?php
} else {
    // --- ENRUTADOR PRINCIPAL ---
    switch ($route) {

        // --- RUTAS DE PERSONA (CRUD Completo) ---
        case 'persona':
        case 'persona/index':
            $controller = new PersonaController();
            $controller->index();
            break;
        case 'persona/create': 
            $controller = new PersonaController();
            $controller->create(); 
            break;
        case 'persona/store': 
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
        case 'persona/eliminar': 
             if (isset($_GET['idpersona'])) {
                $controller = new PersonaController();
                $controller->eliminar($_GET['idpersona']);
            } else {
                echo "Error: Falta el ID de persona para eliminar.";
            }
            break;
        case 'persona/delete': 
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new PersonaController();
                $controller->delete();
            }
            break;
        case 'persona/view': 
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
             if (isset($_GET['id'])) { 
                $controller = new SexoController();
                $controller->edit($_GET['id']); 
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
             if (isset($_GET['id'])) { 
                $controller = new SexoController();
                $controller->eliminar($_GET['id']); 
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
            $controller->create(); 
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
            $controller->create(); 
            break;
        case 'telefono/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new TelefonoController();
                $controller->store();
            }
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
        case 'telefono/eliminar':
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
            // Intentar cargar una vista estática si existe (opcional)
            // $staticView = __DIR__ . '/../app/views/' . $route . '.php';
            // if (file_exists($staticView)) {
            //     require_once $staticView;
            // } else {
                 echo "Error 404: Página no encontrada. (Ruta: '$route')";
            // }
            break;
    }
}
?>

