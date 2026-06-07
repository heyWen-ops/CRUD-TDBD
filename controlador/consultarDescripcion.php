<?php
ob_start();
session_start();
require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

// Hacemos JOIN para traer los nombres en lugar de los IDs
$sql = "SELECT 
            d.id_descripcion, 
            d.precio, 
            mo.nombre AS modelo, 
            c.nombre AS color, 
            ma.nombre AS marca
        FROM descripcion d
        INNER JOIN modelo mo ON d.id_modelo = mo.id_modelo
        INNER JOIN color c ON d.id_color = c.id_color
        INNER JOIN marca ma ON d.id_marca = ma.id_marca";

$stmt = $db->prepare($sql);
$stmt->execute();

$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once "../vista/resultadoDescripcion.php";
ob_end_flush();
?>