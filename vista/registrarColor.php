<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Color</title>
    <link rel="stylesheet" href="../estilos.css">
</head>

<body>

    <header>
        <h1>Registro de Colores</h1>
        <p>Añade un nuevo color al sistema.</p>
    </header>

    <main>

        <section class="tarjeta-formulario">

            <div id="mensaje-respuesta"  style="margin-bottom: 15px; background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; margin: 20px 0; font-size: 16px; text-align: center; display: none;"></div>
            <form id="formColor">

                <div class="grupo-input">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ej. Azul, Morado, Blanco..." required>
                </div>

                <button type="submit" class="btn-guardar">Guardar</button>

            </form>

            <div class="contenedor-volver">
                <a href="../index.php" class="btn-volver">Volver al inicio</a>
            </div>

        </section>

        <script>
            const formColor = document.getElementById('formColor');
            const respuestaDiv = document.getElementById('mensaje-respuesta');

            formColor.addEventListener('submit', function(e) {
                e.preventDefault(); // Evita que la página se recargue

                const datos = new FormData(formColor);

                // Enviamos los datos al controlador
                fetch('../controlador/guardarColor.php', {
                        method: 'POST',
                        body: datos
                    })
                    .then(res => res.text()) // Leemos la respuesta del PHP
                    .then(mensaje => {
                        // Mostramos el mensaje con diseño
                        respuestaDiv.style.display = 'block';
                        respuestaDiv.textContent = mensaje;

                        if (mensaje.includes("correctamente")) {
                            respuestaDiv.style.backgroundColor = "#d4edda"; // Verde éxito
                            respuestaDiv.style.color = "#155724";
                            formColor.reset(); // LIMPIA EL FORMULARIO
                        } else {
                            respuestaDiv.style.backgroundColor = "#f8d7da"; // Rojo error
                            respuestaDiv.style.color = "#721c24";
                        }

                        // Opcional: Desaparecer el mensaje después de 3 segundos
                        setTimeout(() => {
                            respuestaDiv.style.display = 'none';
                        }, 5000);                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        </script>

    </main>

</body>

</html>