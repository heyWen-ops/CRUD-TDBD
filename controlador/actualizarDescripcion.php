<?php
ob_start(); 
session_start();
require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

// Recibir datos del formulario POST
$id_descripcion = $_POST['id_descripcion'];
$precio = $_POST['precio'];
$id_modelo = $_POST['id_modelo'];
$id_color = $_POST['id_color'];
$id_marca = $_POST['id_marca'];

try {
    $sql = "UPDATE descripcion 
            SET precio = :precio, 
                id_modelo = :id_modelo, 
                id_color = :id_color, 
                id_marca = :id_marca 
            WHERE id_descripcion = :id";

    $stmt = $db->prepare($sql);

    // Vincular todos los parámetros
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':id_modelo', $id_modelo);
    $stmt->bindParam(':id_color', $id_color);
    $stmt->bindParam(':id_marca', $id_marca);
    $stmt->bindParam(':id', $id_descripcion);

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
header("Location: consultarDescripcion.php");
ob_end_flush();
exit();
?>