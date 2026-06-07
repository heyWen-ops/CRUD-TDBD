<?php
// 1. Iniciamos sesión de forma segura
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Definimos $resultados como un arreglo vacío si el controlador no lo ha hecho
// Esto evita que la página "explote" si alguien entra directo a la vista
if (!isset($resultados)) {
    $resultados = [];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Ventas</title>
    <link rel="stylesheet" href="../estilos.css">
</head>

<body>

    <header>
        <h1>Lista de Ventas</h1>
        <p>Ventas registradas en el sistema.</p>
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
                                <th>Fecha venta</th>
                                <th>Precio final</th>
                                <th>ID Teléfono</th>
                                <th> </th>
                            </tr>
                        </thead>
                    <tbody>
    <?php foreach ($resultados as $fila): ?>
        <tr>
            <td><?php echo $fila['id_venta']; ?></td>
            <td><?php echo (!empty($fila['fecha_venta'])) ? date("d/m/Y", strtotime($fila['fecha_venta'])) : 'Sin fecha'; ?></td>
            
            <td>$<?php echo number_format($fila['precio_final'], 2); ?></td>
            
            <td><?php echo htmlspecialchars(($fila['marca'] ?? 'N/A') . " " . ($fila['modelo'] ?? '')); ?></td>
            
            <td><?php echo htmlspecialchars($fila['IMEI'] ?? 'Sin IMEI'); ?></td>

            <td>
                <div class="button-group" style="display: flex; gap: 5px;">
                    </div>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="mensaje-vacio">
                    <p>No se encontraron ventas registradas.</p>
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

                fetch('../controlador/eliminarVenta.php', {
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