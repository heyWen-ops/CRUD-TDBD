<?php
ob_start();
session_start();
require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

// Usamos LEFT JOIN para asegurarnos de que la venta aparezca 
// aunque falte algún dato relacionado
$sql = "SELECT v.id_venta, v.fecha_venta, v.precio_final, 
               t.IMEI, ma.nombre AS marca, mo.nombre AS modelo
        FROM venta v
        LEFT JOIN telefono t ON v.id_telefono = t.id_telefono
        LEFT JOIN descripcion d ON t.id_descripcion = d.id_descripcion
        LEFT JOIN marca ma ON d.id_marca = ma.id_marca
        LEFT JOIN modelo mo ON d.id_modelo = mo.id_modelo";

$stmt = $db->prepare($sql);
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once "../vista/resultadoVenta.php";
ob_end_flush();
?>