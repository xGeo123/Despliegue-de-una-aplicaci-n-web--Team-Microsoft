<?php
//controlador sexo
class Sexo {
    private $conn;
    private $table_name = "sexo";

    public $id;
    public $nombre;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear un nuevo sexo
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



     // Leer un solo sexo por ID
    public function readOne() {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en readOne(): " . $e->getMessage());
            return null;
        }
    }

    // Actualizar un sexo
    public function update() {
        try {
            $query = "UPDATE " . $this->table_name . " SET nombre = :nombre WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en update(): " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un sexo
 public function delete() {
    // --- PASO 1: Obtener el ID del sexo "No especificado" ---
    $fallback_id = null;
    try {
        $query_find = "SELECT id FROM " . $this->table_name . " WHERE nombre = 'No especificado' LIMIT 1";
        $stmt_find = $this->conn->prepare($query_find);
        $stmt_find->execute();
        $result = $stmt_find->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $fallback_id = $result['id'];
        } else {
            // Si no existe "No especificado", no podemos continuar.
            error_log("Error en delete(): No se encontró un sexo 'No especificado' para reasignar.");
            echo "Error: Debe crear un sexo 'No especificado' antes de poder borrar otros.";
            return false;
        }
    } catch (PDOException $e) {
        error_log("Error fatal buscando fallback_id: " . $e->getMessage());
        echo "Error fatal al buscar el ID comodín: " . $e->getMessage();
        return false;
    }

    // --- PASO 2: Validar que no estemos borrando el "No especificado" ---
    if ($this->id == $fallback_id) {
        error_log("Error en delete(): Intento de eliminar el sexo 'No especificado'.");
        echo "Error: No puede eliminar el registro 'No especificado' porque es el comodín por defecto.";
        return false;
    }
    
    if (empty($this->id)) {
        return false;
    }

    // --- PASO 3: Iniciar la transacción ---
    try {
        // Iniciar transacción
        $this->conn->beginTransaction();

        // 3a. REASIGNAR: Actualizar la tabla 'persona'
        $query_update = "UPDATE persona SET idsexo = :fallback_id WHERE idsexo = :id_to_delete";
        $stmt_update = $this->conn->prepare($query_update);
        $stmt_update->bindParam(':fallback_id', $fallback_id, PDO::PARAM_INT);
        $stmt_update->bindParam(':id_to_delete', $this->id, PDO::PARAM_INT);
        $stmt_update->execute();
        
        error_log("Registros de 'persona' reasignados desde ID " . $this->id . " a " . $fallback_id);

        // 3b. ELIMINAR: Borrar el registro de 'sexo'
        $query_delete = "DELETE FROM " . $this->table_name . " WHERE id = :id_to_delete";
        $stmt_delete = $this->conn->prepare($query_delete);
        $stmt_delete->bindParam(':id_to_delete', $this->id, PDO::PARAM_INT);
        $stmt_delete->execute();

        // 3c. CONFIRMAR: Si todo salió bien, confirmar los cambios
        $this->conn->commit();
        
        error_log("Registro de 'sexo' con ID " . $this->id . " eliminado exitosamente.");
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
