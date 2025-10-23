<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// En DireccionController.php
// Rutas corregidas usando __DIR__
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Direccion.php';
require_once __DIR__ . '/../models/Persona.php';

class DireccionController {
    private $direccion;
    private $persona; // Necesario para los formularios
    private $db;
    private $basePath = '/apple6b/public/'; // Definido en tu index.php

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->direccion = new Direccion($this->db);
        $this->persona = new Persona($this->db);
    }

    // Mostrar todas las direcciones
    public function index() {
        // Asumiendo que el método se llama 'read()' o 'readAll()'
        // 'read1()' parecía un typo, lo cambié a 'read()'
        $direcciones = $this->direccion->read(); 
        require_once __DIR__ . '/../views/direccion/index.php';
    }

    // --- MUESTRA EL FORMULARIO DE CREACIÓN ---
    // (Tu 'createForm' renombrado a 'create' para seguir el patrón)
    public function create() {
        $personas = $this->persona->read();
        require_once __DIR__ . '/../views/direccion/create.php';
    }

    // --- PROCESA EL FORMULARIO DE CREACIÓN ---
    // (Tu 'create' renombrado a 'store' para seguir el patrón)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['nombre'], $_POST['idpersona'])) {
                $this->direccion->idpersona = $_POST['idpersona'];
                $this->direccion->nombre = $_POST['nombre'];
                
                if ($this->direccion->create()) {
                    header('Location: ' . $this->basePath . 'direccion/index?msg=created');
                } else {
                    header('Location: ' . $this->basePath . 'direccion/index?msg=error');
                }
            } else {
                header('Location: ' . $this->basePath . 'direccion/create?msg=missingdata');
            }
        } else {
            header('Location: ' . $this->basePath . 'direccion/create');
        }
        exit;
    }

    // --- MUESTRA EL FORMULARIO DE EDICIÓN ---
    public function edit($iddireccion) {
        $this->direccion->iddireccion = $iddireccion;
        $direccion = $this->direccion->readOne();
        
        if (!$direccion) {
            die("Error: No se encontró el registro.");
        }
        
        // Cargar personas para el <select>
        $personas = $this->persona->read();

        require_once __DIR__ . '/../views/direccion/edit.php';
    }

    // --- MUESTRA LA VISTA DE CONFIRMACIÓN DE BORRADO ---
    // (Parámetro corregido de $id a $iddireccion)
    public function eliminar($iddireccion) {
        $this->direccion->iddireccion = $iddireccion;
        $direccion = $this->direccion->readOne();

        if (!$direccion) {
            die("Error: No se encontró el registro.");
        }

        require_once __DIR__ . '/../views/direccion/delete.php';
    }

    // --- PROCESA EL FORMULARIO DE EDICIÓN ---
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['iddireccion'], $_POST['nombre'], $_POST['idpersona'])) {
                $this->direccion->iddireccion = $_POST['iddireccion'];
                $this->direccion->idpersona = $_POST['idpersona'];
                $this->direccion->nombre = $_POST['nombre'];

                if ($this->direccion->update()) {
                    header('Location: ' . $this->basePath . 'direccion/index?msg=updated');
                } else {
                    header('Location: ' . $this->basePath . 'direccion/index?msg=error');
                }
            } else {
                $id = $_POST['iddireccion'] ?? 0;
                 header('Location: ' . $this->basePath . 'direccion/edit?iddireccion=' . $id . '&msg=missingdata');
            }
        } else {
            header('Location: ' . $this->basePath . 'direccion/index');
        }
        exit;
    }

    // --- PROCESA EL BORRADO ---
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Corregido: Se buscaba 'id', ahora busca 'iddireccion'
            if (isset($_POST['iddireccion'])) {
                $this->direccion->iddireccion = $_POST['iddireccion'];
                
                if ($this->direccion->delete()) {
                    header('Location: ' . $this->basePath . 'direccion/index?msg=deleted');
                } else {
                    header('Location: ' . $this->basePath . 'direccion/index?msg=error');
                }
            } else {
                header('Location: ' . $this->basePath . 'direccion/index?msg=missingid');
            }
        } else {
            header('Location: ' . $this->basePath . 'direccion/index');
        }
        exit;
    }

    // API (Se mantiene como estaba)
    public function api() {
        while (ob_get_level()) {
            ob_end_clean();
        }

        $direcciones = $this->direccion->getAll(); // Asumiendo que getAll() existe
        header('Content-Type: application/json');
        echo json_encode($direcciones);
        exit;
    }
}

// --- ELIMINADO ---
// Se borró todo el código de enrutamiento que estaba aquí,
// ya que 'public/index.php' se encarga de eso.
?>
