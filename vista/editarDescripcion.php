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
$sql = "SELECT * FROM descripcion WHERE id_descripcion = :id";
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
    <title>Actualizar Descripción</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
    <header>
        <h1>Actualizar Registro</h1>
    </header>
    <main>
        <section class="tarjeta-formulario">
            <form action="../controlador/actualizarDescripcion.php" method="POST">
                
                <input type="hidden" name="id_descripcion" value="<?= $registro['id_descripcion'] ?>">

                <div class="grupo-input">
                    <label>Precio:</label>
                    <input type="number" step="0.01" name="precio" value="<?= $registro['precio'] ?>" required>
                </div>

                <div class="grupo-input">
                    <label>Modelo:</label>
                    <select name="id_modelo" required>
                        <?php foreach ($db->query("SELECT id_modelo, nombre FROM modelo") as $row): ?>
                            <option value="<?= $row['id_modelo'] ?>" <?= $row['id_modelo'] == $registro['id_modelo'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grupo-input">
                    <label>Color:</label>
                    <select name="id_color" required>
                        <?php foreach ($db->query("SELECT id_color, nombre FROM color") as $row): ?>
                            <option value="<?= $row['id_color'] ?>" <?= $row['id_color'] == $registro['id_color'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grupo-input">
                    <label>Marca:</label>
                    <select name="id_marca" required>
                        <?php foreach ($db->query("SELECT id_marca, nombre FROM marca") as $row): ?>
                            <option value="<?= $row['id_marca'] ?>" <?= $row['id_marca'] == $registro['id_marca'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-guardar">Guardar Cambios</button>
                <a href="../controlador/consultarDescripcion.php" class="btn-volver">Cancelar</a>
            </form>
        </section>
    </main>
</body>
</html>