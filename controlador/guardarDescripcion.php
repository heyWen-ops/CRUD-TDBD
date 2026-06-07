<?php

require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

if(isset($_POST['precio'], $_POST['id_modelo'], $_POST['id_color'], $_POST['id_marca']) && 
   !empty(trim($_POST['precio'])) && 
   !empty(trim($_POST['id_modelo'])) && 
   !empty(trim($_POST['id_color'])) && 
   !empty(trim($_POST['id_marca']))) {

    $precio = $_POST['precio'];
    $id_modelo = $_POST['id_modelo'];
    $id_color = $_POST['id_color'];
    $id_marca = $_POST['id_marca'];

    try {
        $sql = "INSERT INTO descripcion (precio, id_modelo, id_color, id_marca)
                VALUES (:precio, :id_modelo, :id_color, :id_marca)";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':id_modelo', $id_modelo);
        $stmt->bindParam(':id_color', $id_color);
        $stmt->bindParam(':id_marca', $id_marca);

        // Ejecutamos y verificamos el éxito de la operación
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