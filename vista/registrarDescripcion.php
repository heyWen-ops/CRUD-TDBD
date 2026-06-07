<?php
// Asegurar inclusión correcta usando ruta absoluta relativa a este archivo
require_once __DIR__ . '/../conexionBD.php';

if (!class_exists('Conexion')) {
    // Mostrar mensaje y detener la ejecución si la clase no está disponible
    echo "<p style='color:red;'>Error: no se encontró la clase Conexion. Verifique conexionBD.php</p>";
    exit;
}

$database = new Conexion();
$db = $database->conectar();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Descripción</title>
    <link rel="stylesheet" href="../estilos.css">
</head>

<body>

    <header>
        <h1>Registro de Descripción</h1>
        <p>Añade una nueva marca al sistema.</p>
    </header>

    <main>
        <section class="tarjeta-formulario">

        <div id="mensaje-respuesta"  style="margin-bottom: 15px; background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; margin: 20px 0; font-size: 16px; text-align: center; display: none;"></div>
            <form id="formDescripcion">

                <div class="grupo-input">
                    <label for="precio">Precio:</label>
                    <input type="number" step="0.01" id="precio" name="precio" placeholder="0.00" required>
                </div>

                <div class="grupo-input">
                    <label for="id_modelo">Modelo:</label>
                    <select name="id_modelo" id="id_modelo" required>
                        <option value="">Selecciona un modelo</option>
                        <?php foreach ($db->query("SELECT id_modelo, nombre FROM modelo") as $row): ?>
                            <option value="<?= $row['id_modelo'] ?>"><?= htmlspecialchars($row['nombre'] ?? '') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grupo-input">
                    <label for="id_color">Color:</label>
                    <select name="id_color" id="id_color" required>
                        <option value="">Selecciona un modelo</option>
                        <?php foreach ($db->query("SELECT id_color, nombre FROM color") as $row): ?>
                            <option value="<?= $row['id_color'] ?>"><?= htmlspecialchars($row['nombre'] ?? '') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grupo-input">
                    <label for="id_marca">Marca:</label>
                    <select name="id_marca" id="id_marca" required>
                        <option value="">Selecciona un modelo</option>
                        <?php foreach ($db->query("SELECT id_marca, nombre FROM marca") as $row): ?>
                            <option value="<?= $row['id_marca'] ?>"><?= htmlspecialchars($row['nombre'] ?? '') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-guardar">Guardar Registro</button>

            </form>

            <div class="contenedor-volver">
                <a href="../index.php" class="btn-volver">Volver al inicio</a>
            </div>

        </section>

        <script>
    const formDescripcion = document.getElementById('formDescripcion');
    const respuestaDiv = document.getElementById('mensaje-respuesta');

    // ¡Cambio aquí! De formColor a formDescripcion
    formDescripcion.addEventListener('submit', function(e) {
        e.preventDefault(); 

        const datos = new FormData(formDescripcion);

        fetch('../controlador/guardarDescripcion.php', {
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
                    // ¡Cambio aquí también! De formColor.reset() a formDescripcion.reset()
                    formDescripcion.reset(); 
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