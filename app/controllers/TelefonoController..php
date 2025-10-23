<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Rutas corregidas usando __DIR__ (asumiendo que este archivo está en /app/controllers)
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Telefono.php';
require_once __DIR__ . '/../../app/models/Persona.php';

class TelefonoController {
    private $telefono;
    private $db;
    private $persona;
    // Definir el basePath para las redirecciones
    private $basePath = '/apple6b/public/';

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->telefono = new Telefono($this->db);
        $this->persona = new Persona($this->db);
    }

    // Mostrar todos los teléfonos
    public function index() {
        $telefonos = $this->telefono->read1(); // Asumo que read1() es correcto
        require_once __DIR__ . '/../../app/views/telefono/index.php';
    }

    // Muestra el formulario de creación (antes 'createForm')
    public function create() {
        $personas = $this->persona->read();
        require_once __DIR__ . '/../../app/views/telefono/create.php';
    }

    // Procesa el formulario de creación (antes 'create')
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['numero']) && isset($_POST['idpersona'])) {
                $this->telefono->idpersona = $_POST['idpersona'];
                $this->telefono->numero = $_POST['numero'];
                
                if ($this->telefono->create()) {
                    header('Location: ' . $this->basePath . 'telefono');
                    exit;
                } else {
                    echo "Error al crear el teléfono";
                }
            } else {
                echo "Faltan datos";
            }
        } else {
            echo "Método incorrecto";
        }
        die();
    }

    // Muestra el formulario de edición
    public function edit($idtelefono) {
        $this->telefono->idtelefono = $idtelefono;
        $telefono = $this->telefono->readOne();
        $personas = $this->persona->read();

        if (!$telefono) {
            die("Error: No se encontró el registro.");
        }

        require_once __DIR__ . '/../../app/views/telefono/edit.php';
    }

    // Muestra la confirmación para eliminar
    public function eliminar($idtelefono) { // Corregido el parámetro
        $this->telefono->idtelefono = $idtelefono; // Usar el parámetro
        $telefono = $this->telefono->readOne();

        if (!$telefono) {
            die("Error: No se encontró el registro.");
        }

        require_once __DIR__ . '/../../app/views/telefono/delete.php';
    }

    // Procesa la actualización
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['numero']) && isset($_POST['idpersona']) && isset($_POST['idtelefono'])) {
                $this->telefono->idpersona = $_POST['idpersona'];
                $this->telefono->numero = $_POST['numero'];
                $this->telefono->idtelefono = $_POST['idtelefono'];
                
                if ($this->telefono->update()) {
                    header('Location: ' . $this->basePath . 'telefono');
                    exit;
                } else {
                    echo "Error al actualizar el teléfono";
                }
            } else {
                echo "Faltan datos";
            }
        } else {
            echo "Método incorrecto";
        }
        die();
    }

    // Procesa la eliminación
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Corregido: buscar 'idtelefono' en lugar de 'id'
            if (isset($_POST['idtelefono'])) { 
                $this->telefono->idtelefono = $_POST['idtelefono'];
                
                if ($this->telefono->delete()) {
                    header('Location: ' . $this->basePath . 'telefono');
                    exit;
                } else {
                    header('Location: ' . $this->basePath . 'telefono?msg=error');
                    exit;
                }
            } else {
                echo "Faltan datos";
            }
        } else {
            echo "Método incorrecto";
        }
        die();
    }

    public function api() {
        while (ob_get_level()) {
            ob_end_clean();
        }
        $telefonos = $this->telefono->getAll();
        header('Content-Type: application/json');
        echo json_encode($telefonos);
        exit;
    }
}

// --- TODO EL BLOQUE DEL ENRUTADOR HA SIDO ELIMINADO ---
// (El 'if (isset($_GET['action']))' no debe estar aquí)
?>

