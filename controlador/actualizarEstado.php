<?php
ob_start(); 
session_start();
require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

// Recibir datos del formulario POST
$id_estado = $_POST['id_estado'];
$descripcion = $_POST['descripcion'];

try {
    $sql = "UPDATE estado 
            SET descripcion = :descripcion
            WHERE id_estado = :id";

    $stmt = $db->prepare($sql);

    // Vincular todos los parámetros
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':id', $id_estado);

    if($stmt->execute()) {
        $_SESSION['mensaje'] = "Registro actualizado correctamente";
        $_SESSION['tipo_mensaje'] = "success";
    } else {
        $_SESSION['mensaje'] = "No se pudo actualizar el registro";
        $_SESSION['tipo_mensaje'] = "error";
    }
} catch(PDOException $e) {
    $_SESSION['mensaje'] = "Error: " . $e->getMessage();
    $_SESSION['tipo_mensaje'] = "error";
}

session_write_close(); 
header("Location: consultarEstado.php");
ob_end_flush();
exit();
?>