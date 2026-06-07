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
    <title>Registro de Venta</title>
    <link rel="stylesheet" href="../estilos.css">
</head>

<body>

    <header>
        <h1>Registro de Venta</h1>
        <p>Añade una nueva venta al sistema.</p>
    </header>

    <main>
        <section class="tarjeta-formulario">

        <div id="mensaje-respuesta"  style="margin-bottom: 15px; background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; margin: 20px 0; font-size: 16px; text-align: center; display: none;"></div>
            <form id="formVenta">

                <div class="grupo-input">
                    <label for="precio_final">Precio Final:</label>
                    <input type="number" step="0.01" id="precio_final" name="precio_final" placeholder="0.00" required>
                </div>

                <div class="grupo-input">
                    <label for="id_telefono">Seleccionar Teléfono:</label>
                    <select name="id_telefono" id="id_telefono" required>
                        <option value="">Selecciona el IMEI del telefono...</option>
                        <?php
                        $sql = "SELECT t.id_telefono, t.IMEI, ma.nombre AS nombre_marca, mo.nombre AS nombre_modelo 
                                FROM telefono t
                                INNER JOIN descripcion d ON t.id_descripcion = d.id_descripcion
                                INNER JOIN marca ma ON d.id_marca = ma.id_marca
                                INNER JOIN modelo mo ON d.id_modelo = mo.id_modelo
                                WHERE t.id_telefono NOT IN (SELECT id_telefono FROM venta)";

                        foreach ($db->query($sql) as $row):
                            $texto_mostrar = htmlspecialchars($row['nombre_marca'] . " " . $row['nombre_modelo'] . " - IMEI: " . $row['IMEI']);
                        ?>
                            <option value="<?= $row['id_telefono'] ?>">
                                <?= $texto_mostrar ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <button type="submit" class="btn-guardar">Guardar</button>

            </form>

            <div class="contenedor-volver">
                <a href="../index.php" class="btn-volver">Volver al inicio</a>
            </div>

        </section>

       <div class="grupo-input">
    <label>Información del equipo:</label>
    <div id="info-telefono" style="padding: 10px; background: #f9f9f9; border: 1px solid #ccc;">
        Selecciona un IMEI para ver la descripción...
    </div>
</div>

<script>
    const formVenta = document.getElementById('formVenta');
    const selectTelefono = document.getElementById('id_telefono');
    const divInfo = document.getElementById('info-telefono');
    const respuestaDiv = document.getElementById('mensaje-respuesta');

    // 1. Lógica para mostrar descripción al cambiar el select
    selectTelefono.addEventListener('change', function() {
        const id = this.value;
        if (id === "") {
            divInfo.textContent = "Selecciona un IMEI para ver la descripción...";
            return;
        }
        fetch('../controlador/obtenerTelefono.php?id=' + id)
            .then(res => res.json())
            .then(data => {
                if (data) {
                    divInfo.innerHTML = `<strong>Marca:</strong> ${data.marca} <br> <strong>Modelo:</strong> ${data.modelo} <br> <strong>Color:</strong> ${data.color} <br> <strong>Precio Venta:</strong> ${data.precio}`;
                } else {
                    divInfo.textContent = "No se encontró información.";
                }
            })
            .catch(err => console.error(err));
    });

    // 2. Lógica para guardar la venta sin recargar la página
    formVenta.addEventListener('submit', function(e) {
        e.preventDefault(); 
        const datos = new FormData(formVenta);

        fetch('../controlador/guardarVenta.php', {
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
                formVenta.reset(); // Limpia los campos
                divInfo.textContent = "Selecciona un IMEI para ver la descripción...";
            } else {
                respuestaDiv.style.backgroundColor = "#f8d7da"; 
                respuestaDiv.style.color = "#721c24";
            }

            setTimeout(() => { respuestaDiv.style.display = 'none'; }, 5000);                    
        })
        .catch(error => { console.error('Error:', error); });
    });
</script>

    </main>

</body>

</html>