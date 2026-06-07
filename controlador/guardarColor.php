<?php
require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

if(isset($_POST['nombre']) && !empty(trim($_POST['nombre']))) {
    $nombre = trim($_POST['nombre']); 

    try {
        $checkSql = "SELECT COUNT(*) FROM color WHERE nombre = :nombre";
        $checkStmt = $db->prepare($checkSql);
        $checkStmt->execute([':nombre' => $nombre]);
        
        if ($checkStmt->fetchColumn() > 0) {
            echo "El color '$nombre' ya está registrado.";
        } else {
            // --- PASO 2: Insertar si no existe ---
            $sql = "INSERT INTO color (nombre) VALUES (:nombre)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            
            if($stmt->execute()) {
                echo "Registro guardado correctamente";
            } else {
                echo "Error al intentar guardar";
            }
        }

    } catch(PDOException $e){
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    echo "El campo nombre es obligatorio";
}
?>