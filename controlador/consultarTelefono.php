<?php
ob_start();
session_start();
require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

// Consulta mejorada con JOINs para ver los nombres reales
$sql = "SELECT 
            t.id_telefono, 
            t.IMEI, 
            t.fecha_registro, 
            ma.nombre AS marca, 
            mo.nombre AS modelo, 
            co.nombre AS color, 
            d.precio, 
            e.descripcion AS estado_equipo
        FROM telefono t
        INNER JOIN descripcion d ON t.id_descripcion = d.id_descripcion
        INNER JOIN marca ma ON d.id_marca = ma.id_marca
        INNER JOIN modelo mo ON d.id_modelo = mo.id_modelo
        INNER JOIN color co ON d.id_color = co.id_color
        INNER JOIN estado e ON t.id_estado = e.id_estado";

$stmt = $db->prepare($sql);
$stmt->execute();

$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once "../vista/resultadoTelefono.php";
ob_end_flush();
?>