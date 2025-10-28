<?php
// Modelo EstadoCivil
class EstadoCivil {
    private $conn;
    private $table_name = "estadocivil";

    public $idestadocivil;
    public $nombre;

    public function __construct($db) {
        $this->conn = $db;
    }


    public function getAll() {
        // Conexión a la base de datos
        $query = $this->conn->query("SELECT * FROM estadocivil");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo estado civil
    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . " (nombre) VALUES (:nombre)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en create(): " . $e->getMessage());
            return false;
        }
    }

    public function read() {
        try {
            $query = "SELECT * FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            error_log("Error en read(): " . $e->getMessage());
            return [];
        }
    }

    // Leer un solo estado civil por ID
    public function readOne() {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE idestadocivil = :idestadocivil LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":idestadocivil", $this->idestadocivil, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en readOne(): " . $e->getMessage());
            return null;
        }
    }

    // Actualizar un estado civil
    public function update() {
        try {
            $query = "UPDATE " . $this->table_name . " SET nombre = :nombre WHERE idestadocivil = :idestadocivil";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(":idestadocivil", $this->idestadocivil, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en update(): " . $e->getMessage());
            return false;
        }
    }

    
    // Eliminar un estado civil con reasignación
    public function delete() {
        // --- PASO 1: Obtener el ID del estado civil "No especificado" ---
        $fallback_id = null;
        try {
            // Usamos la PK correcta: idestadocivil
            $query_find = "SELECT idestadocivil FROM " . $this->table_name . " WHERE nombre = 'No especificado' LIMIT 1";
            $stmt_find = $this->conn->prepare($query_find);
            $stmt_find->execute();
            $result = $stmt_find->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // Usamos la PK correcta: idestadocivil
                $fallback_id = $result['idestadocivil'];
            } else {
                // Si no existe "No especificado", no podemos continuar.
                error_log("Error en delete(): No se encontró un estado civil 'No especificado' para reasignar.");
                echo "Error: Debe crear un estado civil 'No especificado' antes de poder borrar otros.";
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error fatal buscando fallback_id: " . $e->getMessage());
            echo "Error fatal al buscar el ID comodín: " . $e->getMessage();
            return false;
        }

        // --- PASO 2: Validar que no estemos borrando el "No especificado" ---
        // Usamos la propiedad correcta: $this->idestadocivil
        if ($this->idestadocivil == $fallback_id) {
            error_log("Error en delete(): Intento de eliminar el estado civil 'No especificado'.");
            echo "Error: No puede eliminar el registro 'No especificado' porque es el comodín por defecto.";
            return false;
        }
        
        // Usamos la propiedad correcta: $this->idestadocivil
        if (empty($this->idestadocivil)) {
            return false;
        }

        // --- PASO 3: Iniciar la transacción ---
        try {
            // Iniciar transacción
            $this->conn->beginTransaction();

            // 3a. REASIGNAR: Actualizar la tabla 'persona'
            // ¡¡IMPORTANTE!! Asumimos que la columna en 'persona' se llama 'idestadocivil'
            $query_update = "UPDATE persona SET idestadocivil = :fallback_id WHERE idestadocivil = :id_to_delete";
            $stmt_update = $this->conn->prepare($query_update);
            $stmt_update->bindParam(':fallback_id', $fallback_id, PDO::PARAM_INT);
            // Usamos la propiedad correcta: $this->idestadocivil
            $stmt_update->bindParam(':id_to_delete', $this->idestadocivil, PDO::PARAM_INT);
            $stmt_update->execute();
            
            error_log("Registros de 'persona' reasignados desde ID " . $this->idestadocivil . " a " . $fallback_id);

            // 3b. ELIMINAR: Borrar el registro de 'estadocivil'
            // Usamos la PK correcta: idestadocivil
            $query_delete = "DELETE FROM " . $this->table_name . " WHERE idestadocivil = :id_to_delete";
            $stmt_delete = $this->conn->prepare($query_delete);
            // Usamos la propiedad correcta: $this->idestadocivil
            $stmt_delete->bindParam(':id_to_delete', $this->idestadocivil, PDO::PARAM_INT);
            $stmt_delete->execute();

            // 3c. CONFIRMAR: Si todo salió bien, confirmar los cambios
            $this->conn->commit();
            
            error_log("Registro de 'estadocivil' con ID " . $this->idestadocivil . " eliminado exitosamente.");
            return true;

        } catch (PDOException $e) {
            // 3d. REVERTIR: Si algo falló, deshacer todo
            $this->conn->rollBack();
            error_log("Error en la transacción delete(): " . $e->getMessage());
            echo "Error en la transacción al eliminar: " . $e->getMessage();
            return false;
        }
    }
}
?>
