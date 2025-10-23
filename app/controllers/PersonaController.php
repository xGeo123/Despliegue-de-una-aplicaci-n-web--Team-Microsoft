<?php
// En PersonaController.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Persona.php';
require_once __DIR__ . '/../models/Sexo.php';
require_once __DIR__ . '/../models/Estadocivil.php';
require_once __DIR__ . '/../models/Direccion.php';
require_once __DIR__ . '/../models/Telefono.php';

class PersonaController {
    private $persona;
    private $sexo;
    private $estadocivil;
    private $telefono;
    private $direccion;
    private $db;
    private $basePath = '/public/'; // Definido en tu index.php

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->persona = new Persona($this->db);
        $this->sexo = new Sexo($this->db);
        $this->estadocivil = new Estadocivil($this->db);
        $this->telefono = new Telefono($this->db);
        $this->direccion = new Direccion($this->db);
    }

    // Mostrar todas las personas
    public function index() {
        // $personas ya incluye 'sexo_nombre' y 'estadocivil_nombre' gracias al JOIN en el Modelo
        $personas = $this->persona->read(); 
        
        // $sexos y $estadosciviles no son estrictamente necesarios aquí para la tabla,
        // pero podrían usarse para filtros, etc. Los dejamos por si acaso.
        $sexos = $this->sexo->read(); 
        $estadosciviles = $this->estadocivil->read(); 

        require_once __DIR__ . '/../views/persona/index.php';
    }

    // --- MUESTRA EL FORMULARIO DE CREACIÓN ---
    public function create() {
        $sexos = $this->sexo->read();
        $estadosciviles = $this->estadocivil->read();
        require_once __DIR__ . '/../views/persona/create.php';
    }

    // --- PROCESA EL FORMULARIO DE CREACIÓN ---
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (
                isset($_POST['nombres'], $_POST['apellidos'], $_POST['fechanacimiento'], $_POST['idsexo'], $_POST['idestadocivil'])
            ) {
                $this->persona->nombres = $_POST['nombres'];
                $this->persona->apellidos = $_POST['apellidos'];
                $this->persona->fechanacimiento = $_POST['fechanacimiento'];
                $this->persona->idsexo = $_POST['idsexo'];
                $this->persona->idestadocivil = $_POST['idestadocivil'];

                if ($this->persona->create()) {
                    header('Location: ' . $this->basePath . 'persona/index?msg=created');
                } else {
                    header('Location: ' . $this->basePath . 'persona/index?msg=error');
                }
            } else {
                // Faltan datos, redirigir de vuelta al formulario de creación
                header('Location: ' . $this->basePath . 'persona/create?msg=missingdata');
            }
        } else {
            header('Location: ' . $this->basePath . 'persona/create');
        }
        exit;
    }

    // Mostrar el formulario de edición de persona
    public function edit($idpersona) {
        $this->persona->idpersona = $idpersona;
        $persona = $this->persona->readOne(); // $persona ya tiene los JOINs

        if (!$persona) {
            die("Error: No se encontró la persona.");
        }

        // Cargar datos necesarios para los <select> del formulario
        $sexos = $this->sexo->read();
        $estadosciviles = $this->estadocivil->read();

        require_once __DIR__ . '/../views/persona/edit.php';
    }

    // Muestra el registro completo (vista detallada)
    public function registro($idpersona) {
        $this->persona->idpersona = $idpersona;
        $persona = $this->persona->readOne(); // $persona ya tiene los JOINs (sexo_nombre, etc.)

        if (!$persona) {
            die("Error: No se encontró la persona.");
        }
        
        // Cargar datos relacionados
        // $sexos y $estadosciviles ya no son necesarios aquí porque $persona tiene los nombres
        $telefonos = $this->telefono->readByPersona($idpersona); // Asumiendo que Telefono.php tiene readByPersona()
        $direcciones = $this->direccion->readByPersona($idpersona); // Asumiendo que Direccion.php tiene readByPersona()


        require_once __DIR__ . '/../views/persona/registro.php';
    }

    // Procesar la actualización de una persona
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (
                isset($_POST['idpersona'], $_POST['nombres'], $_POST['apellidos'], $_POST['fechanacimiento'], $_POST['idsexo'], $_POST['idestadocivil'])
            ) {
                $this->persona->idpersona = $_POST['idpersona'];
                $this->persona->nombres = $_POST['nombres'];
                $this->persona->apellidos = $_POST['apellidos'];
                $this->persona->fechanacimiento = $_POST['fechanacimiento'];
                $this->persona->idsexo = $_POST['idsexo'];
                $this->persona->idestadocivil = $_POST['idestadocivil'];

                if ($this->persona->update()) {
                    header('Location: ' . $this->basePath . 'persona/index?msg=updated');
                } else {
                    header('Location: ' . $this->basePath . 'persona/index?msg=error');
                }
            } else {
                $id = $_POST['idpersona'] ?? 0;
                header('Location: ' . $this->basePath . 'persona/edit?idpersona=' . $id . '&msg=missingdata');
            }
        } else {
            header('Location: ' . $this->basePath . 'persona/index');
        }
        exit;
    }

    // Mostrar la confirmación de eliminación de persona
    public function eliminar($idpersona) {
        $this->persona->idpersona = $idpersona;
        $persona = $this->persona->readOne();

        if (!$persona) {
            die("Error: No se encontró la persona.");
        }

        require_once __DIR__ . '/../views/persona/delete.php';
    }

    // Procesar la eliminación de una persona
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['idpersona'])) {
                $this->persona->idpersona = $_POST['idpersona'];
                if ($this->persona->delete()) {
                    header('Location: ' . $this->basePath . 'persona/index?msg=deleted');
                } else {
                    header('Location: ' . $this->basePath . 'persona/index?msg=error');
                }
            } else {
                header('Location: ' . $this->basePath . 'persona/index?msg=missingid');
            }
        } else {
            header('Location: ' . $this->basePath . 'persona/index');
        }
        exit;
    }

    // API (Se mantiene como estaba)
    public function api() {
        while (ob_get_level()) {
            ob_end_clean();
        }

        // --- CORRECCIÓN AQUÍ ---
        // El método getAll() fue eliminado del Modelo. Usamos read() en su lugar.
        $personas = $this->persona->read(); 
        header('Content-Type: application/json');
        echo json_encode($personas);
        exit;
    }
}
?>

