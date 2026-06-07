<?php

require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

if(isset($_POST['precio_final'], $_POST['id_telefono']) && !empty(trim($_POST['precio_final'])) && !empty(trim($_POST['id_telefono']))) {
    
    $precio_final = $_POST['precio_final'];
    $id_telefono = $_POST['id_telefono'];

    try {
        // Iniciamos la transacción (Punto de restauración)
        $db->beginTransaction(); 

        $sql = "INSERT INTO venta (precio_final, id_telefono, fecha_venta) 
                VALUES (:precio_final, :id_telefono, NOW())";
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':precio_final', $precio_final);
        $stmt->bindParam(':id_telefono', $id_telefono);
        
        $stmt->execute();

        // Si la ejecución fue exitosa, confirmamos los cambios en la BD
        $db->commit(); 
        echo "Registro guardado correctamente";

    } catch(PDOException $e){
        // Si algo falla dentro del bloque try, revertimos los cambios
        $db->rollBack();
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    echo "Todos los campos son obligatorios";
}

?>