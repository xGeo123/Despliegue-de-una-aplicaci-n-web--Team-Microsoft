<?php
// API REST para Flutter
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// --- MODELOS Y BASE DE DATOS ---
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/Sexo.php';
require_once __DIR__ . '/../app/models/Persona.php';
require_once __DIR__ . '/../app/models/Direccion.php';
require_once __DIR__ . '/../app/models/Telefono.php';
require_once __DIR__ . '/../app/models/Estadocivil.php';

// --- ANÁLISIS DE RUTA ---
$requestUri = $_SERVER["REQUEST_URI"];
$tabla = trim($_GET['table'] ?? '');

// Fallback por path: /api.php/sexo o /public/api/sexo
if ($tabla === '') {
    $path = parse_url($requestUri, PHP_URL_PATH) ?: '';
    $path = rtrim($path, '/');

    if (strpos($path, '/api.php/') !== false) {
        $tabla = substr($path, strrpos($path, '/api.php/') + 9);
    } elseif (strpos($path, '/public/api/') !== false) {
        $tabla = substr($path, strrpos($path, '/public/api/') + 12);
    }

    $tabla = trim($tabla, '/');
    if (strpos($tabla, '/') !== false) {
        $tabla = explode('/', $tabla)[0];
    }
}

$id = null;
$method = $_SERVER['REQUEST_METHOD'];

try {
    $db = (new Database())->getConnection();

    switch ($tabla) {
        case 'sexo':
            if ($method === 'GET') {
                $sexo = new Sexo($db);
                $datos = $sexo->read();
                http_response_code(200);
                echo json_encode(['items' => $datos ?: []]);
            }
            break;

        case 'persona':
            if ($method === 'GET') {
                $persona = new Persona($db);
                $datos = $persona->read();
                http_response_code(200);
                echo json_encode(['items' => $datos ?: []]);
            }
            break;

        case 'direccion':
            if ($method === 'GET') {
                $direccion = new Direccion($db);
                $datos = $direccion->read();
                http_response_code(200);
                echo json_encode(['items' => $datos ?: []]);
            }
            break;

        case 'telefono':
            if ($method === 'GET') {
                $telefono = new Telefono($db);
                $datos = $telefono->read();
                http_response_code(200);
                echo json_encode(['items' => $datos ?: []]);
            }
            break;

        case 'estadocivil':
            if ($method === 'GET') {
                $estadocivil = new Estadocivil($db);
                $datos = $estadocivil->read();
                http_response_code(200);
                echo json_encode(['items' => $datos ?: []]);
            }
            break;

        default:
            http_response_code(404);
            echo json_encode(['error' => 'Tabla no encontrada', 'tabla' => $tabla]);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error del servidor: ' . $e->getMessage()]);
}
