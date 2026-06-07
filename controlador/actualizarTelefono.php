<?php
ob_start(); 
session_start();
require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

// Recibir datos del formulario POST

$id_telefono = $_POST['id_telefono'];
$IMEI = $_POST['IMEI'];
$id_descripcion = $_POST['id_descripcion'];
$id_estado = $_POST['id_estado'];

try {
    $sql = "UPDATE telefono
            SET IMEI = :IMEI, 
                id_descripcion = :id_descripcion, 
                id_estado = :id_estado 
            WHERE id_telefono = :id";

    $stmt = $db->prepare($sql);

    // Vincular todos los parámetros
    $stmt->bindParam(':IMEI', $IMEI);
    $stmt->bindParam(':id_descripcion', $id_descripcion);
    $stmt->bindParam(':id_estado', $id_estado);
    $stmt->bindParam(':id', $id_telefono);

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
header("Location: consultarTelefono.php");
ob_end_flush();
exit();
?>