<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Estado</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

    <header>
        <h1>Registro de Estado</h1>
        <p>Añade un nuevo estado al sistema.</p>
    </header>

    <main>
        <section class="tarjeta-formulario">

        <div id="mensaje-respuesta"  style="margin-bottom: 15px; background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; margin: 20px 0; font-size: 16px; text-align: center; display: none;"></div>            
            <form id="formEstado">
                
                <div class="grupo-input">
                    <label for="descripcion">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion" placeholder="Ej. Disponible, No disponible, Dañado, Vendido..." required>
                </div>
                
                <button type="submit" class="btn-guardar">Guardar</button>
                
            </form>

            <div class="contenedor-volver">
                <a href="../index.php" class="btn-volver">Volver al inicio</a>
            </div>

        </section>

        <script>
            const formEstado = document.getElementById('formEstado');
            const respuestaDiv = document.getElementById('mensaje-respuesta');

            // Cambiamos formColor por formEstado
            formEstado.addEventListener('submit', function(e) {
                e.preventDefault(); 

                const datos = new FormData(formEstado);

                fetch('../controlador/guardarEstado.php', {
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
                            // Cambiamos formColor.reset() por formEstado.reset()
                            formEstado.reset(); 
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