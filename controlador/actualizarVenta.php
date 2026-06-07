<?php
ob_start(); 
session_start();
require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

// Recibir datos del formulario POST
$id_venta = $_POST['id_venta'];
$precio_final = $_POST['precio_final'];
$id_telefono = $_POST['id_telefono'];

try {
    $sql = "UPDATE venta 
            SET precio_final = :precio_final, 
                id_telefono = :id_telefono
            WHERE id_venta = :id";

    $stmt = $db->prepare($sql);

    // Vincular todos los parámetros
    $stmt->bindParam(':precio_final', $precio_final);
    $stmt->bindParam(':id_telefono', $id_telefono);
    $stmt->bindParam(':id', $id_venta);

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
header("Location: consultarVenta.php");
ob_end_flush();
exit();
?>