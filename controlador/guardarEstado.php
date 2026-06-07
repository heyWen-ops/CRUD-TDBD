<?php

require_once __DIR__ . "/../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

if(isset($_POST['descripcion']) && !empty(trim($_POST['descripcion']))) {
    $descripcion = $_POST['descripcion'];

    try {
        $sql = "INSERT INTO estado (descripcion) VALUES (:descripcion)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':descripcion', $descripcion);
        
        if($stmt->execute()) {
            echo "Registro guardado correctamente";
        } else {
            echo "Error al intentar guardar";
        }

    } catch(PDOException $e){
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    echo "El campo nombre es obligatorio";
}

?>