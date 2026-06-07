<?php
require_once "../conexionBD.php";
$database = new Conexion();
$db = $database->conectar();

// Recuperar el ID enviado por el botón
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID no proporcionado");
}

// Consultar los datos actuales de este registro
$sql = "SELECT * FROM color WHERE id_color = :id";
$stmt = $db->prepare($sql);
$stmt->execute([':id' => $id]);
$registro = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$registro) {
    die("Registro no encontrado");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Color</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
    <header>
        <h1>Actualizar Registro</h1>
    </header>
    <main>
        <section class="tarjeta-formulario">
            <form action="../controlador/actualizarColor.php" method="POST">
                
                <input type="hidden" name="id_color" value="<?= $registro['id_color'] ?>">

                <div class="grupo-input">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" value="<?= $registro['nombre'] ?>" required>
                </div>

                <button type="submit" class="btn-guardar">Guardar Cambios</button>
                <a href="../controlador/consultarColor.php" class="btn-volver">Cancelar</a>
            </form>
        </section>
    </main>
</body>
</html>