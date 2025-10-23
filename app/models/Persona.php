<?php
// Modelo Persona
class Persona {
    private $conn;
    private $table_name = "persona";

    // Propiedades de la tabla persona
    public $idpersona;
    public $nombres;
    public $apellidos;
    public $fechanacimiento;
    public $idsexo;
    public $idestadocivil;

    // Constructor para la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear una nueva persona
    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . " (nombres, apellidos, fechanacimiento, idsexo, idestadocivil)
                      VALUES (:nombres, :apellidos, :fechanacimiento, :idsexo, :idestadocivil)";

            $stmt = $this->conn->prepare($query);

            // Bind de los valores
            $stmt->bindParam(":nombres", $this->nombres, PDO::PARAM_STR);
            $stmt->bindParam(":apellidos", $this->apellidos, PDO::PARAM_STR);
            $stmt->bindParam(":fechanacimiento", $this->fechanacimiento, PDO::PARAM_STR);
            $stmt->bindParam(":idsexo", $this->idsexo, PDO::PARAM_INT);
            $stmt->bindParam(":idestadocivil", $this->idestadocivil, PDO::PARAM_INT);

            // CORRECCIÓN: El 'return' debe ir al final.
            if ($stmt->execute()) {
                return true;
            }
            return false;

        } catch (PDOException $e) {
            echo "no grabo:  ".$this->idestadocivil;
            echo $e->getMessage();
            error_log("Error en create() para persona: " . $e->getMessage());
            // CORRECCIÓN: El 'die()' estaba antes del 'return'.
            return false;
        }
    }

    // --- ¡AQUÍ ESTÁ LA CORRECCIÓN! ---
    // Leer todas las personas con los nombres de sexo y estadocivil
    public function read() {
        try {
            // La consulta SQL ahora une las tablas 'sexo' y 'estadocivil'
            // y usa 'AS' para crear los nombres de columna que la Vista espera.
            $query = "SELECT 
                        p.idpersona,
                        p.nombres,
                        p.apellidos,
                        p.fechanacimiento,
                        p.idsexo,
                        p.idestadocivil,
                        s.nombre AS sexo_nombre, 
                        e.nombre AS estadocivil_nombre
                    FROM 
                        " . $this->table_name . " p
                        LEFT JOIN 
                            sexo s ON p.idsexo = s.id
                        LEFT JOIN 
                            estadocivil e ON p.idestadocivil = e.idestadocivil";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            // Devolver los resultados como un array asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error en read() para persona: " . $e->getMessage());
            return [];
        }
    }

    // --- ¡AQUÍ ESTÁ LA OTRA CORRECCIÓN! ---
    // Leer una sola persona por ID, con los nombres
    public function readOne() {
        try {
            $query = "SELECT 
                        p.idpersona,
                        p.nombres,
                        p.apellidos,
                        p.fechanacimiento,
                        p.idsexo,
                        p.idestadocivil,
                        s.nombre AS sexo_nombre, 
                        e.nombre AS estadocivil_nombre
                    FROM 
                        " . $this->table_name . " p
                        LEFT JOIN 
                            sexo s ON p.idsexo = s.id
                        LEFT JOIN 
                            estadocivil e ON p.idestadocivil = e.idestadocivil
                    WHERE
                        p.idpersona = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->idpersona);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                // Asignar valores a las propiedades del objeto
                $this->nombres = $row['nombres'];
                $this->apellidos = $row['apellidos']; // Corregido: $this->apellidos
                $this->fechanacimiento = $row['fechanacimiento'];
                $this->idsexo = $row['idsexo'];
                $this->idestadocivil = $row['idestadocivil'];
                
                return $row; // Devuelve el array completo para la vista
            }
            return null;

        } catch (PDOException $e) {
            error_log("Error en readOne() para persona: " . $e->getMessage());
            return null;
        }
    }

    // Actualizar una persona
    public function update() {
        try {
            $query = "UPDATE " . $this->table_name . " SET
                            nombres = :nombres,
                            apellidos = :apellidos,
                            fechanacimiento = :fechanacimiento,
                            idsexo = :idsexo,
                            idestadocivil = :idestadocivil
                        WHERE idpersona = :idpersona";

            $stmt = $this->conn->prepare($query);

            // Bind de los valores
            $stmt->bindParam(":nombres", $this->nombres, PDO::PARAM_STR);
            $stmt->bindParam(":apellidos", $this->apellidos, PDO::PARAM_STR);
            $stmt->bindParam(":fechanacimiento", $this->fechanacimiento, PDO::PARAM_STR);
            $stmt->bindParam(":idsexo", $this->idsexo, PDO::PARAM_INT);
            $stmt->bindParam(":idestadocivil", $this->idestadocivil, PDO::PARAM_INT);
            $stmt->bindParam(":idpersona", $this->idpersona, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Error en update() para persona: " . $e->getMessage());
            return false;
        }
    }

    // --- MÉTODO getAll() ELIMINADO ---
    // (Era redundante y apuntaba a 'persona1')

    // Eliminar una persona
    public function delete() {
        try {
            if (empty($this->idpersona)) {
                return false;
            }
            error_log("Intentando eliminar la persona con ID: " . $this->idpersona);

            $query = "DELETE FROM " . $this->table_name . " WHERE idpersona = :idpersona";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":idpersona", $this->idpersona, PDO::PARAM_INT);

            if ($stmt->execute()) {
                error_log("Persona con ID " . $this->idpersona . " eliminada correctamente.");
                return true;
            } else {
                error_log("Error en delete() para persona: La consulta no se ejecutó correctamente.");
                return false;
            }

        } catch (PDOException $e) {
            error_log("Error en delete() para persona: " . $e->getMessage());
            return false;
        }
    }
}
?>

