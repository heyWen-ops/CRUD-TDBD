<?php
require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();

if(isset($_POST['nombre']) && !empty(trim($_POST['nombre']))) {
    $nombre = trim($_POST['nombre']); 

    try {
        // --- PASO 1: Verificar si ya existe ---
        $checkSql = "SELECT COUNT(*) FROM modelo WHERE nombre = :nombre";
        $checkStmt = $db->prepare($checkSql);
        $checkStmt->execute([':nombre' => $nombre]);
        
        if ($checkStmt->fetchColumn() > 0) {
            echo "El modelo '$nombre' ya está registrado.";
        } else {
            // --- PASO 2: Insertar si no existe ---
            $sql = "INSERT INTO modelo (nombre) VALUES (:nombre)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            
            if($stmt->execute()) {
                echo "Registro guardado correctamente";
            } else {
                echo "Error al intentar guardar";
            }
        }

    } catch(PDOException $e){
        // Si aplicaste el UNIQUE en la BD, este catch atrapará el error 
        // en caso de que dos personas intenten guardar lo mismo al mismo tiempo.
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    echo "El campo nombre es obligatorio";
}
?>