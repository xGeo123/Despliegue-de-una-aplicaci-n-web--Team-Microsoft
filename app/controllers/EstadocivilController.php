<?php
// MEJORAS EN VISUAL CODE
ini_set('display_errors', 1);
error_reporting(E_ALL);
// En EstadocivilController.php

// Rutas corregidas usando __DIR__
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Estadocivil.php';

// Nombre de clase corregido a PascalCase
class EstadocivilController {
    private $estadocivil;
    private $db;
    private $basePath = '/apple6b/public/'; // Definido en tu index.php

    public function __construct() {
        $this->db = (new Database())->getConnection();
        // Nombre de modelo corregido a PascalCase (asumiendo que el modelo también lo es)
        $this->estadocivil = new Estadocivil($this->db);
    }

    // Mostrar todos los estados civiles
    public function index() {
        $estadosciviles = $this->estadocivil->read();
        require_once __DIR__ . '/../views/estadocivil/index.php';
    }

    // --- MUESTRA EL FORMULARIO DE CREACIÓN ---
    // (Lógica separada del POST)
    public function create() {
        require_once __DIR__ . '/../views/estadocivil/create.php'; // Mostrar el formulario de creación
    }

    // --- PROCESA EL FORMULARIO DE CREACIÓN ---
    // (Nuevo método 'store' para manejar el POST)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['nombre'])) {
                $this->estadocivil->nombre = $_POST['nombre'];
                
                if ($this->estadocivil->create()) {
                    header('Location: ' . $this->basePath . 'estadocivil/index?msg=created');
                } else {
                    header('Location: ' . $this->basePath . 'estadocivil/index?msg=error');
                }
            } else {
                header('Location: ' . $this->basePath . 'estadocivil/create?msg=missingdata');
            }
        } else {
             header('Location: ' . $this->basePath . 'estadocivil/create');
        }
        exit;
    }

    // --- MUESTRA EL FORMULARIO DE EDICIÓN ---
    public function edit($idestadocivil) {
        $this->estadocivil->idestadocivil = $idestadocivil;
        $estadocivil = $this->estadocivil->readOne();
        
        if (!$estadocivil) {
            die("Error: No se encontró el registro.");
        }

        require_once __DIR__ . '/../views/estadocivil/edit.php';
    }

    // --- MUESTRA LA VISTA DE CONFIRMACIÓN DE BORRADO ---
    public function eliminar($idestadocivil) {
        $this->estadocivil->idestadocivil = $idestadocivil;
        $estadocivil = $this->estadocivil->readOne();

        if (!$estadocivil) {
            die("Error: No se encontró el registro.");
        }

        require_once __DIR__ . '/../views/estadocivil/delete.php';
    }

    // --- PROCESA EL FORMULARIO DE EDICIÓN ---
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['idestadocivil'], $_POST['nombre'])) {
                $this->estadocivil->idestadocivil = $_POST['idestadocivil'];
                $this->estadocivil->nombre = $_POST['nombre'];
                
                if ($this->estadocivil->update()) {
                    header('Location: ' . $this->basePath . 'estadocivil/index?msg=updated');
                } else {
                    header('Location: ' . $this->basePath . 'estadocivil/index?msg=error');
                }
            } else {
                $id = $_POST['idestadocivil'] ?? 0;
                header('Location: ' . $this->basePath . 'estadocivil/edit?idestadocivil=' . $id . '&msg=missingdata');
            }
        } else {
            header('Location: ' . $this->basePath . 'estadocivil/index');
        }
        exit;
    }

    // --- PROCESA EL BORRADO ---
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['idestadocivil'])) {
                $this->estadocivil->idestadocivil = $_POST['idestadocivil'];
                
                if ($this->estadocivil->delete()) {
                    header('Location: ' . $this->basePath . 'estadocivil/index?msg=deleted');
                } else {
                    header('Location: ' . $this->basePath . 'estadocivil/index?msg=error');
                }
            } else {
                header('Location: ' . $this->basePath . 'estadocivil/index?msg=missingid');
            }
        } else {
            header('Location: ' . $this->basePath . 'estadocivil/index');
        }
        exit;
    }

    // API (Se mantiene como estaba)
    public function api() {
        while (ob_get_level()) {
            ob_end_clean();
        }

        $estadosciviles = $this->estadocivil->getAll(); // Asumiendo que getAll() existe
        header('Content-Type: application/json');
        echo json_encode($estadosciviles);
        exit;
    }
}

// --- ELIMINADO ---
// Se borró todo el código de enrutamiento que estaba aquí,
// ya que 'public/index.php' se encarga de eso.
?>
