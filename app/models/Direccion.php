<?php
// Modelo Direccion
class Direccion {
    private $conn;
    private $table_name = "direccion";

    // Propiedades de la tabla direccion
    public $iddireccion;
    public $idpersona;
    public $nombre;

    // Constructor para la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear una nueva direccion
    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . " (idpersona, nombre)
                      VALUES (:idpersona, :nombre)";

            $stmt = $this->conn->prepare($query);

            // Bind de los valores
            $stmt->bindParam(":idpersona", $this->idpersona, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);

            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Error en create() para direccion: " . $e->getMessage());
            return false;
        }
    }

    // --- CORREGIDO: Método read() con JOIN ---
    // Leer todas las direcciones con el nombre de la persona
    public function read() {
        try {
            // Consulta con LEFT JOIN para obtener nombre y apellidos de la persona
            $query = "SELECT 
                        d.iddireccion, 
                        d.idpersona, 
                        d.nombre, 
                        CONCAT(p.nombres, ' ', p.apellidos) AS persona_nombre 
                      FROM " . $this->table_name . " d
                      LEFT JOIN persona p ON d.idpersona = p.idpersona
                      ORDER BY d.iddireccion ASC"; // Opcional: ordenar
                      
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error en read() para direccion: " . $e->getMessage());
            return []; // Devolver array vacío en caso de error
        }
    }

    // Leer una sola direccion por ID (sin JOIN, ya que usualmente se usa para formularios)
    public function readOne() {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE iddireccion = :iddireccion LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":iddireccion", $this->iddireccion, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve una sola fila o false

        } catch (PDOException $e) {
            error_log("Error en readOne() para direccion: " . $e->getMessage());
            return null; // O false, dependiendo de cómo manejes errores
        }
    }

    // Actualizar una direccion
    public function update() {
        try {
            $query = "UPDATE " . $this->table_name . " SET
                        idpersona = :idpersona,
                        nombre = :nombre
                      WHERE iddireccion = :iddireccion";

            $stmt = $this->conn->prepare($query);

            // Bind de los valores
            $stmt->bindParam(":idpersona", $this->idpersona, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(":iddireccion", $this->iddireccion, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Error en update() para direccion: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar una direccion
    public function delete() {
        try {
            if (empty($this->iddireccion)) {
                return false; // No hay ID para eliminar
            }
            error_log("Intentando eliminar la direccion con ID: " . $this->iddireccion);

            $query = "DELETE FROM " . $this->table_name . " WHERE iddireccion = :iddireccion";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":iddireccion", $this->iddireccion, PDO::PARAM_INT);

            if ($stmt->execute()) {
                error_log("Direccion con ID " . $this->iddireccion . " eliminada correctamente.");
                return true;
            } else {
                error_log("Error en delete() para direccion: La consulta no se ejecutó correctamente.");
                return false;
            }

        } catch (PDOException $e) {
            error_log("Error en delete() para direccion: " . $e->getMessage());
            return false;
        }
    }

    // Leer todas las direcciones asociadas a una persona específica (sin JOIN aquí)
    public function readByPersona($idpersona) {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE idpersona = :idpersona";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":idpersona", $idpersona, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error en readByPersona() para direccion: " . $e->getMessage());
            return [];
        }
    }
}
?>
