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
$sql = "SELECT * FROM estado WHERE id_estado = :id";
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
    <title>Actualizar Estado</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
    <header>
        <h1>Actualizar Registro</h1>
    </header>
    <main>
        <section class="tarjeta-formulario">
            <form action="../controlador/actualizarEstado.php" method="POST">
                
                <input type="hidden" name="id_estado" value="<?= $registro['id_estado'] ?>">

                <div class="grupo-input">
                    <label>Descripción:</label>
                    <input type="text" name="descripcion" value="<?= $registro['descripcion'] ?>" required>
                </div>

                <button type="submit" class="btn-guardar">Guardar Cambios</button>
                <a href="../controlador/consultarEstado.php" class="btn-volver">Cancelar</a>
            </form>
        </section>
    </main>
</body>
</html>