<?php
ob_start(); 
session_start();
require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

// Recibir datos del formulario POST
$id_modelo = $_POST['id_modelo'];
$nombre = $_POST['nombre'];

try {
    $sql = "UPDATE modelo
            SET nombre = :nombre
            WHERE id_modelo = :id";

    $stmt = $db->prepare($sql);

    // Vincular todos los parámetros
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':id', $id_modelo);

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
header("Location: consultarModelo.php");
ob_end_flush();
exit();
?>