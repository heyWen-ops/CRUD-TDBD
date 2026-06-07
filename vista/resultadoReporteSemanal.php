<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($reporteSemanal)) {
    $reporteSemanal = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Ventas Semanal</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

    <header>
        <h1>Historial de Ventas Semanal</h1>
        <p>Resumen de ingresos y unidades vendidas en la semana actual.</p>
    </header>

    <main>
        <section class="tarjeta-resultado">
            
            <?php if (isset($_SESSION['error_reporte'])): ?>
                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin: 20px 0; text-align: center;">
                    <?= $_SESSION['error_reporte']; unset($_SESSION['error_reporte']); ?>
                </div>
            <?php endif; ?>

            <?php if (count($reporteSemanal) > 0): ?>
                <div class="contenedor-tabla">
                    <table class="tabla-rosita">
    <thead>
        <tr>
            <th>Día de la Semana</th>
            <th>Cantidad</th>
            <th>Total Vendido ($)</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $granTotalDinero = 0;
        $granTotalEquipos = 0;
        
        foreach ($reporteSemanal as $fila): 
            $nombreDia = $diasEspañol[$fila['dia_indice']] ?? $fila['dia_nombre'];
            $granTotalDinero += $fila['total_dinero'];
            $granTotalEquipos += $fila['total_unidades'];
        ?>
            <tr>
                <td><strong><?= htmlspecialchars($nombreDia) ?></strong></td>
                <td><?= $fila['total_unidades'] ?> <?= $fila['total_unidades'] == 1 ? 'equipo' : 'equipos' ?></td>
                <td>$<?= number_format($fila['total_dinero'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
        
        <tr style="background-color: #fce4ec; font-weight: bold; border-top: 2px solid #f8bbd0;">
            <td>Total de la Semana</td>
            <td><?= $granTotalEquipos ?> equipos</td>
            <td>$<?= number_format($granTotalDinero, 2) ?></td>
        </tr>
    </tbody>
</table>
                </div>
            <?php else: ?>
                <div class="mensaje-vacio">
                    <p>Aún no se registran movimientos comerciales en la semana actual.</p>
                </div>
            <?php endif; ?>

            <div class="contenedor-volver" style="margin-top: 30px; display: flex; gap: 10px; justify-content: center;">
                <a href="../index.php" class="btn-volver">Volver al Inicio</a>
            </div>

        </section>
    </main>

</body>
</html>