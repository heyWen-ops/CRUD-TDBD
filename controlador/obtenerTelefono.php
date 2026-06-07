<?php
require_once "../conexionBD.php";
$database = new Conexion();
$db = $database->conectar();

$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "SELECT 
                ma.nombre AS marca, 
                mo.nombre AS modelo, 
                d.precio, 
                c.nombre AS color 
            FROM telefono t
            INNER JOIN descripcion d ON t.id_descripcion = d.id_descripcion
            INNER JOIN marca ma ON d.id_marca = ma.id_marca
            INNER JOIN modelo mo ON d.id_modelo = mo.id_modelo
            INNER JOIN color c ON d.id_color = c.id_color
            WHERE t.id_telefono = :id";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([':id' => $id]);
    $telefono = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode($telefono); // Devuelve marca y modelo
}
?>