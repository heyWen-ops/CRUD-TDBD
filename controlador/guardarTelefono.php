<?php

require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

if(isset($_POST['IMEI'], $_POST['id_descripcion'], $_POST['id_estado']) && 
   !empty(trim($_POST['IMEI'])) && 
   !empty(trim($_POST['id_descripcion'])) && 
   !empty(trim($_POST['id_estado']))) {

    $IMEI = $_POST['IMEI'];
    $id_descripcion = $_POST['id_descripcion'];
    $id_estado = $_POST['id_estado'];

    try {
        $sql = "INSERT INTO telefono (IMEI, id_descripcion, id_estado)
                VALUES (:IMEI, :id_descripcion, :id_estado)";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':IMEI', $IMEI);
        $stmt->bindParam(':id_descripcion', $id_descripcion);
        $stmt->bindParam(':id_estado', $id_estado);

        if($stmt->execute()) {
            echo "Registro guardado correctamente";
        } else {
            echo "Error al intentar guardar";
        }

    } catch(PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    echo "Todos los campos son obligatorios";
}

?>