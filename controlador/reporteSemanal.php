<?php
ob_start();
session_start();
require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

/**
 * Consulta SQL para obtener el acumulado de la semana actual.
 * Filtra usando YEARWEEK() para asegurar que solo entren las ventas de la semana en curso.
 * DAYNAME o WEEKDAY nos ayudan a identificar el día de la semana.
 */
$sql = "SELECT 
            DAYNAME(v.fecha_venta) AS dia_nombre,
            WEEKDAY(v.fecha_venta) AS dia_indice,
            COUNT(v.id_venta) AS total_unidades,
            SUM(v.precio_final) AS total_dinero
        FROM venta v
        WHERE YEARWEEK(v.fecha_venta, 1) = YEARWEEK(NOW(), 1)
        GROUP BY WEEKDAY(v.fecha_venta), DAYNAME(v.fecha_venta) -- <-- Agregado aquí
        ORDER BY WEEKDAY(v.fecha_venta) ASC";

try {
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $reporteSemanal = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $reporteSemanal = [];
    $_SESSION['error_reporte'] = "Error al generar el historial: " . $e->getMessage();
}

// Mapeo manual en español para los días ya que la BD puede estar en inglés
$diasEspañol = [
    0 => 'Lunes',
    1 => 'Martes',
    2 => 'Miércoles',
    3 => 'Jueves',
    4 => 'Viernes',
    5 => 'Sábado',
    6 => 'Domingo'
];

// Incluimos la vista correspondiente
require_once "../vista/resultadoReporteSemanal.php";
ob_end_flush();
?>