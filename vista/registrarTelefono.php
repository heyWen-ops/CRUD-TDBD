<?php
require_once "../conexionBD.php";

$database = new Conexion();
$db = $database->conectar();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Teléfono</title>
    <link rel="stylesheet" href="../estilos.css">
</head>

<body>

    <header>
        <h1>Registro de Teléfono</h1>
        <p>Ingresa los datos del nuevo equipo.</p>
    </header>

    <main>
        <section class="tarjeta-formulario">

            <div id="mensaje-respuesta"  style="margin-bottom: 15px; background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; margin: 20px 0; font-size: 16px; text-align: center; display: none;"></div>
            <form id="formTelefono">

                <div class="grupo-input">
                    <label for="imei">IMEI:</label>
                    <input type="text" id="imei" name="IMEI" placeholder="Ej. 351234567890123" required maxlength="15"
                        pattern="\d{15}" title="El IMEI debe tener exactamente 15 dígitos"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>

                <div class="grupo-input">
                    <label for="id_descripcion">Descripción (Modelo y Precio):</label>
                    <select name="id_descripcion" id="id_descripcion" required>
                        <option value="">Selecciona la descripción</option>
                        <?php 
                        // Hacemos INNER JOIN para traer los nombres reales
                        $sql_desc = "SELECT d.id_descripcion, d.precio, m.nombre AS marca, mo.nombre AS modelo, c.nombre AS color 
                                     FROM descripcion d 
                                     INNER JOIN marca m ON d.id_marca = m.id_marca 
                                     INNER JOIN modelo mo ON d.id_modelo = mo.id_modelo 
                                     INNER JOIN color c ON d.id_color = c.id_color";
                                     
                        foreach ($db->query($sql_desc) as $row): 
                        ?>
                            <option value="<?= $row['id_descripcion'] ?>">
                                <?= htmlspecialchars($row['marca'] . " " . $row['modelo'] . " (" . $row['color'] . ") - $" . $row['precio']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grupo-input">
                    <label for="id_estado">Estado:</label>
                    <select name="id_estado" id="id_estado" required>
                        <option value="">Selecciona el estado del equipo</option>
                        <?php foreach ($db->query("SELECT id_estado, descripcion FROM estado") as $row): ?>
                            <option value="<?= $row['id_estado'] ?>"><?= htmlspecialchars($row['descripcion'] ?? '') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-guardar">Guardar</button>
            </form>

            <div class="contenedor-volver">
                <a href="../index.php" class="btn-volver">Volver al inicio</a>
            </div>

        </section>

        <script>
            const formTelefono = document.getElementById('formTelefono');
            const respuestaDiv = document.getElementById('mensaje-respuesta');

            // Cambiamos formColor por formTelefono
            formTelefono.addEventListener('submit', function(e) {
                e.preventDefault();

                const datos = new FormData(formTelefono);

                fetch('../controlador/guardarTelefono.php', {
                        method: 'POST',
                        body: datos
                    })
                    .then(res => res.text())
                    .then(mensaje => {
                        respuestaDiv.style.display = 'block';
                        respuestaDiv.textContent = mensaje;

                        if (mensaje.includes("correctamente")) {
                            respuestaDiv.style.backgroundColor = "#d4edda";
                            respuestaDiv.style.color = "#155724";
                            // Cambiamos formColor.reset() por formTelefono.reset()
                            formTelefono.reset();
                        } else {
                            respuestaDiv.style.backgroundColor = "#f8d7da";
                            respuestaDiv.style.color = "#721c24";
                        }

                        setTimeout(() => {
                            respuestaDiv.style.display = 'none';
                        }, 5000);                    
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        </script>

    </main>

</body>

</html>