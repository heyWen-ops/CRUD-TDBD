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
$sql = "SELECT * FROM venta WHERE id_venta = :id";
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
    <title>Actualizar Venta</title>
    <link rel="stylesheet" href="../estilos.css">
</head>

<body>
    <header>
        <h1>Actualizar Registro</h1>
    </header>
    <main>
        <section class="tarjeta-formulario">
            <form action="../controlador/actualizarVenta.php" method="POST">

                <input type="hidden" name="id_venta" value="<?= $registro['id_venta'] ?>">

                <div class="grupo-input">
                    <label>Precio Final:</label>
                    <input type="number" step="0.01" name="precio_final" value="<?= $registro['precio_final'] ?>" required>
                </div>

                <div class="grupo-input">
                    <label for="id_telefono">Seleccionar Teléfono:</label>
                    <select name="id_telefono" id="id_telefono" required>
                        <?php
                        $sql = "SELECT 
                            t.id_telefono, 
                            t.IMEI, 
                            ma.nombre AS nombre_marca, 
                            mo.nombre AS nombre_modelo 
                        FROM telefono t
                        INNER JOIN descripcion d ON t.id_descripcion = d.id_descripcion
                        INNER JOIN marca ma ON d.id_marca = ma.id_marca
                        INNER JOIN modelo mo ON d.id_modelo = mo.id_modelo";

                        foreach ($db->query($sql) as $row):
                            $texto_mostrar = htmlspecialchars($row['nombre_marca'] . " " . $row['nombre_modelo'] . " - IMEI: " . $row['IMEI']);
                            $seleccionado = ($row['id_telefono'] == $registro['id_telefono']) ? 'selected' : '';
                        ?>
                            <option value="<?= $row['id_telefono'] ?>" <?= $seleccionado ?>>
                                <?= $texto_mostrar ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-guardar">Guardar Cambios</button>
                <a href="../controlador/consultarVenta.php" class="btn-volver">Cancelar</a>
            </form>
        </section>
    </main>
</body>

</html>