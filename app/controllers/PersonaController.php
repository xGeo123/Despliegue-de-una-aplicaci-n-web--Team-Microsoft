<?php
// En PersonaController.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/apple6b/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/apple6b/app/models/Persona.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/apple6b/app/models/Sexo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/apple6b/app/models/Estadocivil.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/apple6b/app/models/Direccion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/apple6b/app/models/Telefono.php';
class PersonaController {
    private $persona;
    private $db;

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
        $personas = $this->persona->read();
        $sexos = $this->sexo->read();
        $estadosciviles = $this->estadocivil->read();

        require_once '../app/views/persona/index.php';
    }

    // Mostrar el formulario de creación de persona
    public function createForm() {


        $sexos = $this->sexo->read();
        $estadosciviles = $this->estadocivil->read();
        require_once '../app/views/persona/create.php';
    }

    // Procesar la creación de una nueva persona
    public function create() {
    //    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      //      if (
        //        isset($_POST['nombres']) &&
          //      isset($_POST['apellidos']) &&
         //       isset($_POST['fechanacimiento']) &&
         //       isset($_POST['idsexo']) &&
         //       isset($_POST['idestadocivil'])
         //   ) {
                $this->persona->nombres = $_POST['nombres'];
                $this->persona->apellidos = $_POST['apellidos'];
                $this->persona->fechanacimiento = $_POST['fechanacimiento'];
                $this->persona->idsexo = $_POST['idsexo'];
                $this->persona->idestadocivil = $_POST['idestadocivil'];

                if ($this->persona->create()) {
                    echo "personas creada con exito";
                //    header('Location: index?msg=created');
          //          exit;
                } else {


                    $error = "Error al crear la persona.";
                    require_once '../app/views/persona/create.php'; // Puedes pasar el error a la vista
                    exit;
                }
         //   } else {
       // $sexos = $this->sexo->read();
      //  $estadosciviles = $this->estadocivil->read();

       // die(" 3");

         //       $error = "Faltan datos en el formulario.";
           //     require_once '../app/views/persona/create.php'; // Puedes pasar el error a la vista
           //     exit;
           // }
       // } else {
         //   header('Location: index.php'); // Redirigir si no es POST
          //  exit;
       // }
    }

    // Mostrar el formulario de edición de persona
    public function edit($idpersona) {
        $this->persona->idpersona = $idpersona;
        $sexos = $this->sexo->read();
        $estadosciviles = $this->estadocivil->read();
        $persona = $this->persona->readOne();

        if (!$persona) {
            die("Error: No se encontró la persona.");
        }

        require_once '../app/views/persona/edit.php';
    }

    public function registro($idpersona) {
        $this->persona->idpersona = $idpersona;
        $sexos = $this->sexo->read();
        $estadosciviles = $this->estadocivil->read();

        $telefonos = $this->telefono->readByPersona($idpersona);
        $direcciones = $this->direccion->readByPersona($idpersona);
        $persona = $this->persona->readOne();

        if (!$persona) {
            die("Error: No se encontró la persona.");
        }

        require_once '../app/views/persona/registro.php';
    }

 


    // Procesar la actualización de una persona
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (
                isset($_POST['idpersona']) &&
                isset($_POST['nombres']) &&
                isset($_POST['apellidos']) &&
                isset($_POST['fechanacimiento']) &&
                isset($_POST['idsexo']) &&
                isset($_POST['idestadocivil'])
            ) {
                $this->persona->idpersona = $_POST['idpersona'];
                $this->persona->nombres = $_POST['nombres'];
                $this->persona->apellidos = $_POST['apellidos'];
                $this->persona->fechanacimiento = $_POST['fechanacimiento'];
                $this->persona->idsexo = $_POST['idsexo'];
                $this->persona->idestadocivil = $_POST['idestadocivil'];

                if ($this->persona->update()) {
                    header('Location: index.php?msg=updated');
                    exit;
                } else {
                    $error = "Error al actualizar la persona.";
                    $this->editForm($_POST['idpersona']); // Volver al formulario con error
                    exit;
                }
            } else {
                $error = "Faltan datos en el formulario de actualización.";
                $this->editForm($_POST['idpersona']); // Volver al formulario con error
                exit;
            }
        } else {
            header('Location: index.php'); // Redirigir si no es POST
            exit;
        }
    }

    // Mostrar la confirmación de eliminación de persona
    public function deleteForm($idpersona) {
        $this->persona->idpersona = $idpersona;
        $persona = $this->persona->readOne();

        if (!$persona) {
            die("Error: No se encontró la persona.");
        }

        require_once '../app/views/persona/delete.php';
    }

    // Procesar la eliminación de una persona
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['idpersona'])) {
                $this->persona->idpersona = $_POST['idpersona'];
                if ($this->persona->delete()) {
                    header('Location: index.php?msg=deleted');
                    exit;
                } else {
                    header('Location: index.php?msg=error_delete');
                    exit;
                }
            } else {
                header('Location: index.php?msg=no_id_delete');
                exit;
            }
        } else {
            header('Location: index.php'); // Redirigir si no es POST
            exit;
        }
    }

    public function api() {

        while (ob_get_level()) {
            ob_end_clean();
        }

        $personas = $this->persona->getAll();
        header('Content-Type: application/json');
        echo json_encode($personas);
        exit;



    }
}

// Manejo de la acción en la URL
if (isset($_GET['action'])) {
    $controller = new PersonaController();
    $action = $_GET['action'];

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } elseif (isset($_POST['idpersona'])) {
        $id = $_POST['idpersona'];
    } else {
        $id = null;
    }

    switch ($_GET['action']) {
        case 'index':
            $controller->index();
            break;
        case 'createForm':
            $controller->createForm();
            break;
        case 'create':
            $controller->create();
            break;
        case 'editForm':
            if ($id !== null) {
                $controller->editForm($id);
            } else {
                echo "Error: ID de persona no especificado para editar.";
            }
            break;
        case 'update':
            $controller->update();
            break;
        case 'deleteForm':
            if ($id !== null) {
                $controller->deleteForm($id);
            } else {
                echo "Error: ID de persona no especificado para eliminar.";
            }
            break;
        case 'delete':
            $controller->delete();
            break;
        case 'api':

        $controller->api();
        break;
        default:
            echo "Acción no válida.";
            break;
    }
} else {
   // $controller = new PersonaController();
  //  $controller->index(); // Acción por defecto si no se especifica ninguna

}
?>
