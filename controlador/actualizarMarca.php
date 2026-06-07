<?php
ob_start(); 
session_start();
require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

$id_marca = $_POST['id_marca'];
$nombre = $_POST['nombre'];

try {
    $sql = "UPDATE marca SET nombre = :nombre WHERE id_marca = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':id', $id_marca);

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
header("Location: consultarMarca.php");
ob_end_flush();
exit();
?>