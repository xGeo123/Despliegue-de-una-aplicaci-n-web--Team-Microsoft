<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Rutas corregidas para ser llamadas desde routes/web.php (que está en /public)
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Sexo.php';

class SexoController {
    private $sexo;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->sexo = new Sexo($this->db);
    }

    // Mostrar todos los sexos
    public function index() {
        $sexos = $this->sexo->read();
        // Ruta corregida a la vista
        require_once __DIR__ . '/../../app/views/sexo/index.php';
    }

    // Mostrar el formulario de creación
    public function create() {
        // Simplemente mostramos la vista del formulario
        require_once __DIR__ . '/../../app/views/sexo/create.php';
    }

    // Almacenar (guardar) un nuevo registro
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['nombre'])) {
                $this->sexo->nombre = $_POST['nombre'];
                if ($this->sexo->create()) {
                    // Éxito: Redirigir al listado
                    header('Location: /public/sexo');
                    exit;
                } else {
                    echo "Error al crear el sexo";
                }
            } else {
                echo "Faltan datos";
            }
        } else {
            echo "Método incorrecto";
        }
        die();
    }

    // Mostrar el formulario de edición
    public function edit($id) {
        $this->sexo->id = $id;
        $sexo = $this->sexo->readOne();

        if (!$sexo) {
            die("Error: No se encontró el registro.");
        }

        require_once __DIR__ . '/../../app/views/sexo/edit.php';
    }

    // Mostrar la vista de confirmación de eliminación
    public function eliminar($id) {
        $this->sexo->id = $id;
        $sexo = $this->sexo->readOne();

        if (!$sexo) {
            die("Error: No se encontró el registro.");
        }

        require_once __DIR__ . '/../../app/views/sexo/delete.php';
    }

    // Actualizar un registro existente
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['nombre']) && isset($_POST['id'])) {
                $this->sexo->nombre = $_POST['nombre'];
                $this->sexo->id = $_POST['id'];
                
                if ($this->sexo->update()) {
                    // Éxito: Redirigir al listado
                    header('Location: /public/sexo');
                    exit;
                } else {
                    echo "Error al actualizar el sexo";
                }
            } else {
                echo "Faltan datos";
            }
        } else {
            echo "Método incorrecto";
        }
        die();
    }

    // Eliminar un registro
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id'])) {
                $this->sexo->id = $_POST['id'];
                if ($this->sexo->delete()) {
                    // Éxito: Redirigir al listado
                    header('Location: /public/sexo');
                    exit;
                } else {
                    echo "Error al eliminar el sexo";
                }
            } else {
                echo "Faltan datos";
            }
        } else {
            echo "Método incorrecto";
        }
        die();
    }
}

// --- IMPORTANTE ---
// Hemos eliminado el enrutador antiguo que estaba aquí.
// También eliminamos el <!DOCTYPE html> del inicio.
// Haz lo mismo para tu TelefonoController.php