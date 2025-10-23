<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Rutas corregidas usando __DIR__
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Telefono.php'; // Corregido: '../models/'
require_once __DIR__ . '/../models/Persona.php';  // Corregido: '../models/'

class TelefonoController {
    private $telefono;
    private $db;
    private $persona;
    // CORREGIDO: basePath actualizado
    private $basePath = '/public/'; 

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->telefono = new Telefono($this->db);
        $this->persona = new Persona($this->db);
    }

    // Mostrar todos los teléfonos
    public function index() {
        // CORREGIDO: Llamar al método read() que tiene el JOIN
        $telefonos = $this->telefono->read(); 
        require_once __DIR__ . '/../views/telefono/index.php'; // Corregido: '../views/'
    }

    // Muestra el formulario de creación
    public function create() {
        $personas = $this->persona->read();
        require_once __DIR__ . '/../views/telefono/create.php'; // Corregido: '../views/'
    }

    // Procesa el formulario de creación
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['numero']) && isset($_POST['idpersona'])) {
                $this->telefono->idpersona = $_POST['idpersona'];
                $this->telefono->numero = $_POST['numero'];
                
                if ($this->telefono->create()) {
                    // CORREGIDO: Redirección limpia
                    header('Location: ' . $this->basePath . 'telefono?msg=created');
                    exit;
                } else {
                     header('Location: ' . $this->basePath . 'telefono?msg=error');
                     exit;
                }
            } else {
                 header('Location: ' . $this->basePath . 'telefono/create?msg=missingdata');
                 exit;
            }
        } else {
             header('Location: ' . $this->basePath . 'telefono/create');
             exit;
        }
        // No debería llegar aquí, pero por si acaso
        // die(); // Eliminado
    }

    // Muestra el formulario de edición
    public function edit($idtelefono) {
        $this->telefono->idtelefono = $idtelefono;
        $telefono = $this->telefono->readOne();
        $personas = $this->persona->read();

        if (!$telefono) {
            die("Error: No se encontró el registro.");
        }

        require_once __DIR__ . '/../views/telefono/edit.php'; // Corregido: '../views/'
    }

    // Muestra la confirmación para eliminar
    public function eliminar($idtelefono) { 
        $this->telefono->idtelefono = $idtelefono; 
        $telefono = $this->telefono->readOne();

        if (!$telefono) {
            die("Error: No se encontró el registro.");
        }

        require_once __DIR__ . '/../views/telefono/delete.php'; // Corregido: '../views/'
    }

    // Procesa la actualización
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['numero']) && isset($_POST['idpersona']) && isset($_POST['idtelefono'])) {
                $this->telefono->idpersona = $_POST['idpersona'];
                $this->telefono->numero = $_POST['numero'];
                $this->telefono->idtelefono = $_POST['idtelefono'];
                
                if ($this->telefono->update()) {
                    // CORREGIDO: Redirección limpia
                    header('Location: ' . $this->basePath . 'telefono?msg=updated');
                    exit;
                } else {
                    header('Location: ' . $this->basePath . 'telefono?msg=error');
                    exit;
                }
            } else {
                 $id = $_POST['idtelefono'] ?? 0;
                 header('Location: ' . $this->basePath . 'telefono/edit?idtelefono=' . $id . '&msg=missingdata');
                 exit;
            }
        } else {
             header('Location: ' . $this->basePath . 'telefono');
             exit;
        }
        // die(); // Eliminado
    }

    // Procesa la eliminación
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['idtelefono'])) { 
                $this->telefono->idtelefono = $_POST['idtelefono'];
                
                if ($this->telefono->delete()) {
                    // CORREGIDO: Redirección limpia
                    header('Location: ' . $this->basePath . 'telefono?msg=deleted');
                    exit;
                } else {
                    header('Location: ' . $this->basePath . 'telefono?msg=error');
                    exit;
                }
            } else {
                 header('Location: ' . $this->basePath . 'telefono?msg=missingid');
                 exit;
            }
        } else {
             header('Location: ' . $this->basePath . 'telefono');
             exit;
        }
       // die(); // Eliminado
    }

    public function api() {
        while (ob_get_level()) {
            ob_end_clean();
        }
        // CORREGIDO: Usar read() en lugar de getAll()
        $telefonos = $this->telefono->read(); 
        header('Content-Type: application/json');
        echo json_encode($telefonos);
        exit;
    }
}

// --- TODO EL BLOQUE DEL ENRUTADOR HA SIDO ELIMINADO ---
?>

