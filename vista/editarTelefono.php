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
$sql = "SELECT * FROM telefono WHERE id_telefono = :id";
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
    <title>Actualizar Teléfono</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
    <header>
        <h1>Actualizar Registro</h1>
    </header>
    <main>
        <section class="tarjeta-formulario">
            <form action="../controlador/actualizarTelefono.php" method="POST">
                
                <input type="hidden" name="id_telefono" value="<?= $registro['id_telefono'] ?>">

                <div class="grupo-input">
                    <label>IMEI:</label>
                    <input type="text" name="IMEI" value="<?= htmlspecialchars($registro['IMEI']) ?>" required>
                </div>

                <div class="grupo-input">
                    <label>Equipo (Marca, Modelo, Precio):</label>
                    <select name="id_descripcion" required>
                        <?php 
                        // Hacemos un JOIN para que puedas ver toda la info al seleccionar
                        // Si tienes una tabla de 'color', puedes agregarla al JOIN aquí mismo
                        $sqlDesc = "SELECT d.id_descripcion, d.precio, ma.nombre AS marca, mo.nombre AS modelo 
                                    FROM descripcion d
                                    INNER JOIN marca ma ON d.id_marca = ma.id_marca
                                    INNER JOIN modelo mo ON d.id_modelo = mo.id_modelo";
                        
                        foreach ($db->query($sqlDesc) as $row): 
                            // Aquí corregimos la sintaxis del 'selected'
                            $seleccionado = ($row['id_descripcion'] == $registro['id_descripcion']) ? 'selected' : '';
                            $texto_mostrar = htmlspecialchars($row['marca'] . " " . $row['modelo'] . " - $" . number_format($row['precio'], 2));
                        ?>
                            <option value="<?= $row['id_descripcion'] ?>" <?= $seleccionado ?>>
                                <?= $texto_mostrar ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grupo-input">
                    <label>Estado:</label>
                    <select name="id_estado" required>
                        <?php 
                        foreach ($db->query("SELECT id_estado, descripcion FROM estado") as $row): 
                            // También corregimos la sintaxis aquí
                            $seleccionado = ($row['id_estado'] == $registro['id_estado']) ? 'selected' : '';
                        ?>
                            <option value="<?= $row['id_estado'] ?>" <?= $seleccionado ?>>
                                <?= htmlspecialchars($row['descripcion']) ?>
                            </option> 
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-guardar">Guardar Cambios</button>
                <a href="../controlador/consultarTelefono.php" class="btn-volver">Cancelar</a>
            </form>
        </section>
    </main>
</body>
</html>