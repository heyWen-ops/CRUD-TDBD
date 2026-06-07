<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conecta W&H</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <header>
        <img src="image/snoopy.gif" alt="Logo Conecta W&H" class="logo">
        <h1>Conecta W&H</h1>
        <p>Panel de Administración de Inventario</p>
    </header>

    <main>
        <section>
            <h2>Teléfonos</h2>
            <ul>
                <li><a href="vista/registrarTelefono.php">Registrar Teléfono</a></li>
                <li><a href="controlador/consultarTelefono.php">Ver Lista de Teléfonos</a></li>
            </ul>
        </section>

        <section>
            <h2>Marcas</h2>
            <ul>
                <li><a href="vista/registrarMarca.php">Registrar Marca</a></li>
                <li><a href="controlador/consultarMarca.php">Ver Lista de Marcas</a></li>
            </ul>
        </section>

        <section>
            <h2>Modelos</h2>
            <ul>
                <li><a href="vista/registrarModelo.php">Registrar Modelo</a></li>
                <li><a href="controlador/consultarModelo.php">Ver Lista de Modelos</a></li>
            </ul>
        </section>

        <section>
            <h2>Colores</h2>
            <ul>
                <li><a href="vista/registrarColor.php">Registrar Color</a></li>
                <li><a href="controlador/consultarColor.php">Ver Lista de Colores</a></li>
            </ul>
        </section>

        <section>
            <h2>Descripciones</h2>
            <ul>
                <li><a href="vista/registrarDescripcion.php">Registrar Descripción</a></li>
                <li><a href="controlador/consultarDescripcion.php">Ver Lista de Descripciones</a></li>
            </ul>
        </section>

        <section>
            <h2>Estados</h2>
            <ul>
                <li><a href="vista/registrarEstado.php">Registrar Estado</a></li>
                <li><a href="controlador/consultarEstado.php">Ver Lista de Estados</a></li>
            </ul>
        </section>

        <section>
            <h2>Ventas</h2>
            <ul>
                <li><a href="vista/registrarVenta.php">Registrar Venta</a></li>
                <li><a href="controlador/consultarVenta.php">Ver Lista de Ventas</a></li>
                <li><a href="controlador/reporteSemanal.php">Ver Reporte Semanal</a></li>
            </ul>
        </section>
    </main>

</body>
</html>