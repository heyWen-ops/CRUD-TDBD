<?php
ob_start();
session_start();
require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

// Consultar todos los campos y todos los registros
$sql = "SELECT * FROM marca";

//$sql = "SELECT id_marca, nombre FROM marca WHERE nombre LIKE 'm%' ";

$stmt = $db->prepare($sql);
$stmt->execute();

$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once "../vista/resultadoMarca.php";
ob_end_flush();
?>