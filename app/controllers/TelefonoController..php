<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// En TelefonoController.php
// Rutas corregidas usando __DIR__
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Telefono.php';
require_once __DIR__ . '/../models/Persona.php'; // Necesario para los formularios

class TelefonoController {
    private $telefono;
    private $persona; // Necesario para los formularios
    private $db;
    private $basePath = '/apple6b/public/'; // Definido en tu index.php

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->telefono = new Telefono($this->db);
        $this->persona = new Persona($this->db); // Inicializar el modelo Persona
    }

    // Mostrar todos los teléfonos
    public function index() {
        $telefonos = $this->telefono->read();
        require_once __DIR__ . '/../views/telefono/index.php';
    }

    // --- MUESTRA EL FORMULARIO DE CREACIÓN ---
    public function create() {
        // Necesitamos la lista de personas para el <select>
        $personas = $this->persona->read();
        
        require_once __DIR__ . '/../views/telefono/create.php';
    }

    // --- PROCESA EL FORMULARIO DE CREACIÓN ---
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Validar que ambos campos lleguen
            if (isset($_POST['numero'], $_POST['idpersona'])) {
                
                $this->telefono->numero = $_POST['numero'];
                $this->telefono->idpersona = $_POST['idpersona']; // Añadido campo faltante

                if ($this->telefono->create()) {
                    header('Location: ' . $this->basePath . 'telefono/index?msg=created');
                } else {
                    header('Location: ' . $this->basePath . 'telefono/index?msg=error');
                }
            } else {
                 header('Location: ' . $this->basePath . 'telefono/create?msg=missingdata');
            }
        } else {
            header('Location: ' . $this->basePath . 'telefono/create');
        }
        exit;
    }

    // --- MUESTRA EL FORMULARIO DE EDICIÓN ---
    public function edit($id) {
        $this->telefono->id = $id;
        $telefono = $this->telefono->readOne();

        if (!$telefono) {
            die("Error: No se encontró el registro.");
        }
        
        // Necesitamos la lista de personas para el <select>
        $personas = $this->persona->read();

        require_once __DIR__ . '/../views/telefono/edit.php';
    }

    // --- PROCESA EL FORMULARIO DE EDICIÓN ---
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Validar que lleguen todos los campos
            if (isset($_POST['id'], $_POST['numero'], $_POST['idpersona'])) {
                
                $this->telefono->id = $_POST['id'];
                $this->telefono->numero = $_POST['numero'];
                $this->telefono->idpersona = $_POST['idpersona']; // Añadido campo faltante

                if ($this->telefono->update()) {
                    header('Location: ' . $this->basePath . 'telefono/index?msg=updated');
                } else {
                    header('Location: ' . $this->basePath . 'telefono/index?msg=error');
                }
            } else {
                // Corregir el ID que se envía de vuelta
                $id = $_POST['id'] ?? 0;
                header('Location: ' . $this->basePath . 'telefono/edit?id=' . $id . '&msg=missingdata');
            }
        } else {
            header('Location: ' . $this->basePath . 'telefono/index');
        }
        exit;
    }

    // --- MUESTRA LA VISTA DE CONFIRMACIÓN DE BORRADO ---
    public function eliminar($id) {
        $this->telefono->id = $id;
        $telefono = $this->telefono->readOne();

        if (!$telefono) {
            die("Error: No se encontró el registro.");
        }

        require_once __DIR__ . '/../views/telefono/delete.php';
    }

    // --- PROCESA EL BORRADO ---
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id'])) {
                $this->telefono->id = $_POST['id'];
                
                if ($this->telefono->delete()) {
                    header('Location: ' . $this->basePath . 'telefono/index?msg=deleted');
                } else {
                    header('Location: ' . $this->basePath . 'telefono/index?msg=error');
                }
            } else {
                header('Location: ' . $this->basePath . 'telefono/index?msg=missingid');
            }
        } else {
            header('Location: ' . $this->basePath . 'telefono/index');
        }
        exit;
    }
}

// --- ELIMINADO ---
// Se borró todo el código de enrutamiento que estaba aquí,
// ya que 'public/index.php' se encarga de eso.
?>

