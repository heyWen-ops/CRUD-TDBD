<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Colores</title>
    <link rel="stylesheet" href="../estilos.css">
</head>

<body>

    <header>
        <h1>Lista de Colores</h1>
        <p>Colores registradas en el sistema.</p>
    </header>

    <main>
        <section class="tarjeta-resultado">

            <?php if (isset($_SESSION['mensaje'])): ?>
                <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px solid #c3e6cb; margin: 20px 0; font-size: 16px; text-align: center;">
                    <?php echo $_SESSION['mensaje']; ?>
                </div>
                <?php
                unset($_SESSION['mensaje']);
                unset($_SESSION['tipo_mensaje']);
                ?>
            <?php endif; ?>

            <div id="mensaje-respuesta"  style="margin-bottom: 15px; background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; margin: 20px 0; font-size: 16px; text-align: center; display: none;"></div>

            <?php if (count($resultados) > 0): ?>
                <div class="contenedor-tabla">
                    <table class="tabla-rosita">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre del Color</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $fila): ?>
                                <tr>
                                    <td><?php echo $fila['id_color']; ?></td>
                                    <td style="font-weight: 500; color: #be185d;">
                                        <?php echo $fila['nombre']; ?>
                                    </td>

                                    <td>
                                        <div class="button-group" style="display: flex; gap: 5px;">
                                            <form action="../vista/editarColor.php" method="GET">
                                                <input type="hidden" name="id" value="<?= $fila['id_color']; ?>">
                                                <button type="submit" class="btn btn-update">Actualizar</button>
                                            </form>

                                            <form class="form-eliminar">
                                                <input type="hidden" name="id" value="<?= $fila['id_color']; ?>">
                                                <button type="button" class="btn btn-delete" onclick="eliminarRegistro(this)">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="mensaje-vacio">
                    <p>No se encontraron colores registrados.</p>
                </div>
            <?php endif; ?>

            <div class="contenedor-volver">
                <a href="../index.php" class="btn-volver">Volver al inicio</a>
            </div>

        </section>

        <script>
            function eliminarRegistro(boton) {
                if (!confirm('¿Eliminar este registro?')) return;

                const formulario = boton.closest('.form-eliminar');
                const fila = boton.closest('tr');
                const respuestaDiv = document.getElementById('mensaje-respuesta');
                const datos = new FormData(formulario);

                fetch('../controlador/eliminarColor.php', {
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
                            respuestaDiv.style.border = "1px solid #c3e6cb";

                            fila.remove();
                        } else {
                            respuestaDiv.style.backgroundColor = "#f8d7da";
                            respuestaDiv.style.color = "#721c24";
                            respuestaDiv.style.border = "1px solid #f5c6cb";
                        }

                        setTimeout(() => {
                            respuestaDiv.style.display = 'none';
                        }, 5000);                    })
                    .catch(error => console.error('Error:', error));
            }
        </script>

    </main>

</body>

</html>