<?php
require_once "../conexionBD.php";
$database = new Conexion();
$db = $database->conectar();

if (isset($_POST['id']) && !empty(trim($_POST['id']))) {
    $id = $_POST['id'];

    try {
        $sql = "DELETE FROM estado WHERE id_estado = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            echo "Registro eliminado correctamente";
        } else {
            echo "Error al intentar eliminar el registro";
        }

    } catch(PDOException $e) {
        if ($e->getCode() == "23000") {
            echo "No se puede eliminar: Este estado está asociado a uno o más teléfonos existentes.";
        } else {
            echo "Error en la base de datos: " . $e->getMessage();
        }
    }
} else {
    echo "ID no válido para eliminar";
}
?>